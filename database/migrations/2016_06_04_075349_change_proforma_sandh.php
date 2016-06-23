<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeProformaSandh extends Migration
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
          $table->renameColumn('shipped', 'sandh');
        });
        Schema::table('proforma_invoices', function($table)
          {
            $table->string('sandh')->nullable()->change();
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
