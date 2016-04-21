<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommercialInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commercial_invoices', function (Blueprint $table) {
          $table->increments('id');
          $table->date('create_date')->nullable();
          $table->string('order_id');
          $table->date('export_date')->nullable();
          $table->string('terms_of_sale')->nullable();
          $table->string('reference')->nullable();
          $table->string('currency')->nullable();
          $table->integer('customer_id')->nullable();
          $table->string('exporter')->nullable();
          $table->string('manufacture_country')->nullable();
          $table->string('consignee')->nullable();
          $table->string('notify_party')->nullable();
          $table->string('destination_country')->nullable();
          $table->string('airwaybill_number')->nullable();
          $table->integer('packages')->nullable();
          $table->double('final_total')->nullable();
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
        Schema::drop('commercial_invoices');
    }
}
