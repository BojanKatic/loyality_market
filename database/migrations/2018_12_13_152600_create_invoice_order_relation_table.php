<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceOrderRelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_order_relation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('invoice_id');
            $table->integer('invoice_product_id');
            $table->integer('invoice_product_sum');
            $table->decimal('invoice_product_price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_order_relation');
    }
}
