<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyUserRightsToUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('users', function($table)
      {
        $table->boolean('administrator')->default(false)->after('email');
        $table->boolean('inventory')->default(false)->after('administrator');
        $table->boolean('purchase')->default(false)->after('inventory');
        $table->boolean('customer')->default(false)->after('purchase');
        $table->boolean('proforma')->default(false)->after('customer');
        $table->boolean('commercial')->default(false)->after('proforma');
        $table->boolean('data_export')->default(false)->after('commercial');
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
