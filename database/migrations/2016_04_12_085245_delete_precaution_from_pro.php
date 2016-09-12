<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeletePrecautionFromPro extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('proforma_invoices', function($table)
        {
          $table->dropColumn('precautions');
        });
        Schema::table('purchase_records', function($table)
          {
            $table->string('precautions')->after('undertaker')->change();
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
