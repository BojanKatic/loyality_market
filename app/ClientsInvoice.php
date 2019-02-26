<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientsInvoice extends Model
{
    protected $table = 'invoice_order';

    protected $fillable = [
        'invoice_created_by_id', 'invoice_client_id','invoice_order_sum', 'invoice_order_date',
    ];
    
}
