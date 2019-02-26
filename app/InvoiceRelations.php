<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceRelations extends Model
{
    protected $table = 'invoice_order_relation';

    protected $fillable = [
        'invoice_id', 'invoice_product_id','invoice_product_sum', 'invoice_product_price',
    ];
    
}
