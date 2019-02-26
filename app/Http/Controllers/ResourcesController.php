<?php

namespace App\Http\Controllers;

use App\Resources;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ResourcesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        $resources = Resources::paginate(10);
        return view('resources.index', compact('resources'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('resources.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validation of fields
        $atributes = request()->validate([
            'name' => 'required|min:2',
            'price' => 'required',
            'quantity' => 'required'
        ]);

        $resource_name = request('name');
        $resource_quantity = request('quantity');
        $resource_price = request('price');

        Resources::create([
            'name'=> $resource_name,
            'price'=> $resource_price,
            'quantity'=> $resource_quantity,
            'last_update'=> date('Y-m-d')
        ]);

        
        //creating log of new resource
        DB::table('log')->insert ([
            ['description' => 'Created new resource '. $resource_name  .' with price '. $resource_price  .' and quantity '. $resource_quantity  .' ' , 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
        ]);
        $request->session()->flash('status', 'Task was successful!');
        return redirect('/resources');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Resources  $resources
     * @return \Illuminate\Http\Response
     */
    public function show(Resources $resources)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Resources  $resources
     * @return \Illuminate\Http\Response
     */
    public function edit(Resources $resource)
    {
        return view('resources.edit', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Resources  $resources
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Resources $resource)
    {
        $atributes = request()->validate([
            'name' => 'required|min:2',
            'price' => 'required'
        ]);

        $resource_name = request('name');
        $resource_price = request('price');

        $resource->update([
            'name'=> request('name'),
            'price'=> request('price') 
        ]);

        //creating log of price for resource
        DB::table('log')->insert ([
            ['description' => 'Updated resource '. $resource_name  .' with new price '. $resource_price  .' ' , 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
        ]);
        $request->session()->flash('status', 'Task was successful!');
        return redirect('/resources');

    }
    public function updateSum(Request $request, Resources $resource)
    {
        $resource->increment('quantity', request('quantity'));
        $resource->update([
            'last_update'=> date('Y-m-d')
        ]);
        $resource_quantity = request('quantity');
        //creating log of new quantity for resource
        DB::table('log')->insert ([
            ['description' => 'Updated resource '. $resource['name']  .' quantity for  '. $resource_quantity  .' ' , 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
        ]);
        return redirect('/resources');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Resources  $resources
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resources $resource)
    {
        $resource->delete();
        session()->flash('status', 'Resource sucessiful deleted!');
        return redirect('/resources');
    }

    public function ajax(Request $request)
    {    
        session_start();
        $niz_pravi = array();
        $resource_name = Resources::select('name')->where('id', $request->resource_id)->get();

        $resource_id= $request->resource_id;
        $resource_quantity= $request->new_quantity;
        $resource_new_price= $request->newPrice;
        $resource_nameFormatec = $resource_name['0']['name'];

        $itemArray = array(
                array(  
                    'resurs_id' => $resource_id,
                    'resource_quantity' => $resource_quantity,
                    'resource_new_price' => $resource_new_price,
                )
        );

        $_SESSION["kosara"]["$resource_id"] = $itemArray;

        $count_of_items_in_cart = count($_SESSION["kosara"]);

        
        return $count_of_items_in_cart;
  
    }
    public function cart_reset()
    {
        session_start();
        session_destroy();
    }
    public function cart($id)
    {
        $client_data = DB::table('clients')
        ->where('id', $id)->get(); 

        $resources = Resources::all();
        return view('clients.cart', compact('resources', 'client_data'));
    }
}
