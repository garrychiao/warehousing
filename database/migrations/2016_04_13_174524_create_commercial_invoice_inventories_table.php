<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommercialInvoiceInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commercial_invoice_inventories', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('commercial_invoice_id')->nullable();
          $table->integer('inventory_id')->nullable();
          $table->string('item_code')->nullable();
          $table->integer('quantity')->nullable();
          $table->double('unit_price')->nullable();
          $table->double('total')->nullable();
          $table->string('description')->nullable();
          $table->double('weight')->nullable();
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
        Schema::drop('commercial_invoice_inventories');
    }
}
