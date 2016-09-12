<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateInventory extends Migration
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
          $table->string('item_id');
          $table->string('category');
          $table->string('item_name');
          $table->string('standard');
          $table->string('graph_id');
          $table->string('barcode');
          $table->integer('inventory');
          $table->string('unit');
          $table->integer('safety_inventory');
          $table->double('avg_cost');
          $table->double('price1');
          $table->double('price2');
          $table->double('price3');
          $table->double('price4');
          $table->double('price5');
          $table->double('price6');
          $table->string('descriptions');
          $table->string('remark');
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
