<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CustomerModify extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('customers', function($table)
        {
          $table->string('customer_id')->after('id');
          $table->string('short_name')->after('eng_name');
          $table->string('owner')->after('short_name');
          $table->string('contact_person')->after('owner');
          $table->string('fax')->after('cell_phone');
          $table->string('invoice')->after('EIN');
          $table->string('check')->after('invoice');
          $table->string('nationality')->after('check');
          $table->string('currency')->after('nationality');
          $table->string('remark')->after('currency');
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
