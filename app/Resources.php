<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Resources extends Model
{
    protected $fillable = [
        'name', 'price', 'quantity', 'last_update'
    ];

    public function listMail($decodedOrderList)
    {
        $b = 0;
        $c = 0; 
        
        foreach($decodedOrderList as $decodedList){
            $b++;
            $c++;
            $realniBrojReal= $decodedList['product'];
            $realResourceName = Resources::select('name')->where('id', $realniBrojReal)->get();
            $meil_array[] =array([ 
                'resource_name' => $realResourceName['0']['name'],
                'resource_price' => $decodedList['amount'],
                'resource_sum' => $decodedList['quantity']
            ]);

        }
        return $meil_array;
    }


    public function invoices($id){ 
        return $this->hasMany(DB::table('invoice_order')->where('invoice_client_id', $id)->get());
    }
}
