<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQuotationToShippingRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('my_companies', function($table)
        {
          $table->text('quotation')->after('fax')->nullable();
        });
        Schema::table('proforma_invoices', function($table)
        {
          $table->text('quotation')->after('sandh')->nullable();
        });
        Schema::table('commercial_invoices', function($table)
        {
          $table->text('quotation')->after('airwaybill_number')->nullable();
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
