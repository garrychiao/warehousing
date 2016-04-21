<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('supplier_id');
            $table->string('order_id');
            $table->date('purchase_date')->nullable();
            $table->date('delivery_date')->nullable();
            $table->string('payment_terms')->nullable();
            $table->double('unit_price')->nullable();
            $table->string('delivery_address')->nullable();
            $table->string('packing')->nullable();
            $table->string('shipping_sample')->nullable();
            $table->string('undertaker')->nullable();
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
        Schema::drop('purchase_records');
    }
}
