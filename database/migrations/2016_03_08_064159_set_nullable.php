<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('inventories', function($table)
        {
          $table->string('item_id')->nullable()->change();
          $table->string('category')->nullable()->change();
          $table->string('item_name')->nullable()->change();
          $table->string('standard')->nullable()->change();
          $table->string('graph_id')->nullable()->change();
          $table->string('barcode')->nullable()->change();
          $table->integer('inventory')->nullable()->change();
          $table->string('unit')->nullable()->change();
          $table->integer('safety_inventory')->nullable()->change();
          $table->float('avg_cost')->nullable()->change();
          $table->float('price1')->nullable()->change();
          $table->float('price2')->nullable()->change();
          $table->float('price3')->nullable()->change();
          $table->float('price4')->nullable()->change();
          $table->float('price5')->nullable()->change();
          $table->float('price6')->nullable()->change();
          $table->string('descriptions')->nullable()->change();
          $table->string('remark')->nullable()->change();
        });

        Schema::table('customers', function($table)
          {
            $table->string('customer_id')->nullable()->change();
            $table->string('short_name')->nullable()->change();
            $table->string('owner')->nullable()->change();
            $table->string('contact_person')->nullable()->change();
            $table->string('fax')->nullable()->change();
            $table->string('invoice')->nullable()->change();
            $table->string('check')->nullable()->change();
            $table->string('nationality')->nullable()->change();
            $table->string('currency')->nullable()->change();
            $table->string('remark')->nullable()->change();
          });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
