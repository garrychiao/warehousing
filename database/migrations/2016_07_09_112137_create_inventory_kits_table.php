<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryKitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_kits', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kits_id')->nullable();
            $table->string('kits_name')->nullable();
            $table->string('kits_description')->nullable();
            $table->double('kits_weight')->nullable();
            $table->double('price1')->nullable();
            $table->double('price2')->nullable();
            $table->double('price3')->nullable();
            $table->double('price4')->nullable();
            $table->double('price5')->nullable();
            $table->double('price6')->nullable();
            $table->integer('inventory_id')->nullable();
            $table->double('quantity')->nullable();
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
        Schema::drop('inventory_kits');
    }
}
