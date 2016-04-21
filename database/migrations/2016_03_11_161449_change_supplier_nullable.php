<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeSupplierNullable extends Migration
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
          $table->string('supplier_id')->nullable()->change();
          $table->string('supplier_name')->nullable()->change();
          $table->string('short_name')->nullable()->change();
          $table->string('owner')->nullable()->change();
          $table->string('phone')->nullable()->change();
          $table->string('cell_phone')->nullable()->change();
          $table->string('fax')->nullable()->change();
          $table->string('zip_code')->nullable()->change();
          $table->string('address')->nullable()->change();
          $table->string('remark')->nullable()->change();
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
