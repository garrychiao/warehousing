<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSupplier extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('suppliers', function($table)
        {
          $table->string('supplier_id');
          $table->string('supplier_name');
          $table->string('short_name');
          $table->string('owner');
          $table->string('phone');
          $table->string('cell_phone');
          $table->string('fax');
          $table->string('zip_code');
          $table->string('address');
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
