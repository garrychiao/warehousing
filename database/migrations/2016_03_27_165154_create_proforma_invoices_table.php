<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProformaInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proforma_invoices', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('customer_id');
          $table->string('order_id');
          $table->date('create_date')->nullable();
          $table->date('due_date')->nullable();
          $table->string('bill_to')->nullable();
          $table->string('ship_to')->nullable();
          $table->string('POnumber')->nullable();
          $table->string('payment_terms')->nullable();
          $table->string('rep')->nullable();
          $table->string('ship')->nullable();
          $table->string('via')->nullable();
          $table->string('FOB')->nullable();
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
        Schema::drop('proforma_invoices');
    }
}
