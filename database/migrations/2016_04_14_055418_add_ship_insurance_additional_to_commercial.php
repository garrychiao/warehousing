<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShipInsuranceAdditionalToCommercial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('commercial_invoices', function($table)
        {
          $table->double('cost_shipping')->after('packages')->nullable();
          $table->double('cost_insurance')->after('cost_shipping')->nullable();
          $table->double('cost_additional')->after('cost_insurance')->nullable();
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
