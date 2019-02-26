<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Clients extends Model
{
    protected $fillable =[
        'name', 'image', 'email', 'date_of_birth', 'created_by', 'spent', 'shopingSumCount'
    ];

    public function invoicePagination($id)
    {
        $invoice_count=DB::table('invoice_order')->where('invoice_client_id', $id)->count();

    }
}
