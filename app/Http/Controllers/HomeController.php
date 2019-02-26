<?php

namespace App\Http\Controllers;

use App\ClientsInvoice;
use App\InvoiceRelations;
use App\Clients;
use App\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $log= DB::table('log')->orderBy('id', 'desc')->take(5)->get();
        $clients = DB::table('clients')->count();
        $resources = DB::table('resources')->count();
        $invoiceSevenDays =  DB::table('invoice_order')->where( 'created_at', '>', Carbon::now()->subDays(7))
           ->count();

        $countingData = array([
            'clients' => $clients,
            'resources' => $resources,
            'invoiceSevenDays' => $invoiceSevenDays
        ]);
        // most active clients
        $client_activity= DB::table('clients')->orderBy('spent', 'desc')->take(5)->get();

        // Last 5 transactions
        $client_invoices = ClientsInvoice::orderBy('id', 'desc')->take(5)->get();

        $last_invoices = array();
        foreach($client_invoices as $invoice_data)
        {
            $client_data = Clients::select('name')->where('id', $invoice_data->invoice_client_id)->get();
            $last_invoices[] = array(
                'client_name' => $client_data['0']['name'],
                'invoice_sum' => $invoice_data->invoice_order_sum,
                'invoice_creation_date' => $invoice_data->invoice_order_date
            );
        }

         // List of sold resource quantity from start
        $list_of_used_products = InvoiceRelations::groupBy('invoice_product_id')
        ->selectRaw('sum(invoice_product_sum) as used_sum, invoice_product_id')
        ->orderBy('used_sum', 'desc')
        ->take(5)->get( 'used_sum','invoice_product_id');
        $list_of_used_products_jsoned = json_decode($list_of_used_products, true);

        $most_used_resources= array();
        foreach($list_of_used_products_jsoned as $used_products_jsoned)
        {
            if(Resources::where('id', '=', $used_products_jsoned['invoice_product_id'])->exists()){
            $resource_real_name= Resources::select('name')->where('id', $used_products_jsoned['invoice_product_id'])->get();
            $most_used_resources[] = array(
                'resource_name' => $resource_real_name['0']['name'],
                'resource_used_sum' => $used_products_jsoned['used_sum']
            );
            }
        }

        return view('home', compact('log', 'countingData', 'last_invoices', 'client_activity', 'most_used_resources'));
    }
    public function search(Request $request)
    {
        if($request->ajax()){
            $output="";
            $products=DB::table('clients')->where('name','LIKE','%'.$request->search."%")->take(5)->get();
            if($products){
                foreach ($products as $key => $product) {
                $output.=
                '<li><a href="clients/'.$product->id.'"> '. $product->name .' </li>';
                }
                return Response($output);
            }
        }
    }
}
