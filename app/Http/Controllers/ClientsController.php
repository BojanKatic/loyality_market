<?php

namespace App\Http\Controllers;

use App\Clients;
use App\Resources;
use App\ClientsInvoice;
use App\InvoiceRelations;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Mail\InvoiceOrder;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Clients::paginate(10);
        $avg_stars = DB::table('clients')->where('id', 1)
        ->avg('spent');

        return view('clients.index', compact('clients', 'avg_stars'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $atributes = request()->validate([
            'name' => 'required|min:3',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'email' => 'required|email',
            'date_of_birth' => 'required|date'
        ]);
        if(request('image') != NULL){
            $imageName = time().'_'.request()->image->getClientOriginalName();
            request()->image->move(public_path('images'), $imageName);
        }else{
            $imageName = '';
        }
        

        Clients::create([
            'name'=> request('name'),
            'image'=> $imageName,
            'email'=> request('email'),
            'date_of_birth'=> request('date_of_birth'),
            'spent'=> 0,
            'shopingSumCount'=> 0,
            'created_by'=> auth()->user()->id
        ]);


        //creating log of new client
        DB::table('log')->insert ([
            ['description' => 'Created new client '. request('name')  .' ' , 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
        ]);

        $request->session()->flash('status', 'Creating client was sucessiful!');
        return redirect('/clients');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function show(Clients $client)
    {


        $invoice_count = DB::table('invoice_order')->where('invoice_client_id', $client->id)->count();
        $pagination_list_count = ceil($invoice_count / 10);
        $all_client_invoices = DB::table('invoice_order')
        ->where('invoice_client_id', $client->id)->get();  

        if($invoice_count <= 10)
        {
            $racuni = DB::table('invoice_order')
            ->where('invoice_client_id', $client->id)->get();         
        }
        if ( isset($_GET["page"]) )
        {
        $page = $_GET["page"];
        $show_page  = $page*10;   

            $racuni = DB::table('invoice_order')
            ->where('invoice_client_id', $client->id)
            ->skip($show_page)->take(10)->get();;
        }else{
            $racuni = DB::table('invoice_order')
            ->where('invoice_client_id', $client->id)
            ->skip(0)->take(10)->get();;
        }

        return view('clients.show', compact('client', 'racuni', 'pagination_list_count'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function edit(Clients $client)
    {
        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Clients $client)
    {
        $atributes = request()->validate([
            'name' => 'required|min:3',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'email' => 'required|email',
            'date_of_birth' => 'required|date'
        ]);

        if(request('image') != NULL){
            if($client->image != NULL){
                $clientImage = public_path("images/{$client->image}"); // get previous image from folder
                unlink($clientImage); // unlink or remove previous image from folder
            }
            $imageName = time().'_'.request()->image->getClientOriginalName();
            request()->image->move(public_path('images'), $imageName);
        }else{
            $imageName = $client->image;
        }
        $client->update([
            'name'=> request('name'),
            'image'=> $imageName,
            'email'=> request('email'),
            'date_of_birth'=> request('date_of_birth')
        ]);

        //creating log of update client
        DB::table('log')->insert ([
            ['description' => 'Updated client '. request('name')  .' ' , 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
        ]);

        $request->session()->flash('status', 'Client edit was successful!');
        return redirect('/clients');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function destroy(Clients $client)
    {
        //creating log of update client
        DB::table('log')->insert ([
            ['description' => ''. date('Y-m-d H:i:s') .' deleted client '. $client->name  .' ' , 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
        ]);

        $client->delete();
        return redirect('/clients');
    }

    public function invoice(Clients $client)
    {
        $resources = Resources::paginate(10);
        
        return view('clients.invoice', compact('resources','client'));
    }

    public function showInvoice(ClientsInvoice $invoice)
    {
        //Get invoice realtionfrom base
        $invoice_relation = DB::table('invoice_order_relation')
        ->where('invoice_id', $invoice->id)->get();
        // creating array for invoice data
        $invoice_content_data = array();
        $a = -1;
        foreach($invoice_relation as $relation){
            $a++;
            
            $resurs = Resources::select('name', 'price')->where('id', $relation->invoice_product_id)->get();
            $invoice_content_data[] =array(
                'invoice_resource_name' => $resurs['0']['name'],
                'invoice_resource_price' => $resurs['0']['price'],
                'invoice_product_sum' => $invoice_relation[''.$a.'']->invoice_product_sum,
                'invoice_product_price' => $invoice_relation[''.$a.'']->invoice_product_price
            );
        }
      
        return view('clients.invoice_show', compact('invoice', 'invoice_content_data'));
    }

    public function finishInvoice(Request $request)
    {
        $cart_amount = $request->cart_amount;

        $clean_total_format = str_replace(".", "", $cart_amount);

        $stripe = [
          "secret_key"      => "sk_test_nbOvU4UHVNZo8kO4Ei3udvPQ",
          "publishable_key" => "pk_test_c5TashnOBNfPfSj2oQUwJL6r",
        ];

        \Stripe\Stripe::setApiKey($stripe['secret_key']); 

        $token  = $_POST['stripeToken'];
        $email  = $_POST['stripeEmail'];
      
        $customer = \Stripe\Customer::create([
            'email' => $email,
            'source'  => $token,
        ]);
      
        $charge = \Stripe\Charge::create([
            'customer' => $customer->id,
            'amount'   => $clean_total_format,
            'currency' => 'BAM',
        ]);

        $order_main_data = $request->session()->get('orderData');
        $order_main_data_jsoned = json_decode($order_main_data, true);

        $insertIntoInvoiceTable = ClientsInvoice::Create([
                'invoice_created_by_id' => $order_main_data_jsoned['0']['registred_admin'],
                'invoice_client_id' => $order_main_data_jsoned['0']['clientId'],
                'invoice_order_sum' => $order_main_data_jsoned['0']['invoiceSum'],
                'invoice_order_date' => date('Y-m-d H:i:s')
        ]);

    
        $value = $request->session()->get('orderList');
        $decodedOrderList = json_decode($value, true);
        $i = 0;

        foreach($decodedOrderList as $decodedList){
            $i++;
            $realniBroj= $decodedList['product'];

        $invoice_data = InvoiceRelations::Create([
                'invoice_id' => $insertIntoInvoiceTable->id,
                'invoice_product_id' => $realniBroj,
                'invoice_product_sum' => $decodedList['quantity'],
                'invoice_product_price' => $decodedList['amount']
            ]);
            DB::table('resources')->where('id', $realniBroj)->decrement('quantity', $decodedList['quantity']);

        }
        $trenutnoStanjePotrosnje = Clients::select('spent', 'shopingSumCount','email')->where('id', $order_main_data_jsoned['0']['clientId'])->get();

        DB::table('clients')
            ->where('id', $order_main_data_jsoned['0']['clientId'])
            ->update([  'spent' => $trenutnoStanjePotrosnje['0']['spent'] + $order_main_data_jsoned['0']['invoiceSum'],
                        'shopingSumCount' => $trenutnoStanjePotrosnje['0']['shopingSumCount'] + 1]);

        $user_full_name = DB::table('clients')->select('name')->where('id', $order_main_data_jsoned['0']['clientId'])->get();

        //creating log of update client
        DB::table('log')->insert ([
            ['description' => 'Created invoice for client '. $user_full_name['0']->name  .', total sum: '.$order_main_data_jsoned['0']['invoiceSum'].' ' , 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
        ]);
        
        
        //Send meil to client with invoice data
        $foo = new Resources(); 
        $meil_array = $foo->listMail($decodedOrderList);

        $total_invoice_sum = $order_main_data_jsoned['0']['invoiceSum'];


        \Mail::to($trenutnoStanjePotrosnje['0']['email'])->send(
            new InvoiceOrder($meil_array, $total_invoice_sum)
        );


        session_start();

        session_destroy();
    
        return redirect('/clients');
    }
    public function racunKOntrola(Request $request)
    {

        dd($request);
        $resources = Resources::all();
        
        return view('clients.invoice', compact('resources'));
    }
}
