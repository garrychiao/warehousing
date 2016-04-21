<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseInventoryRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_inventory_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('purchase_records_id')->nullable();
            $table->integer('inventory_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->double('unit_price')->nullable();
            $table->string('remark')->nullable();
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
        Schema::drop('purchase_inventory_records');
    }
}
