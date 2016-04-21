<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToMycompany extends Migration
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
          $table->string('eng_name')->after('name')->nullable();
          $table->string('EIN')->after('eng_name')->nullable();
          $table->string('contact_person')->after('EIN')->nullable();
          $table->string('eng_address')->after('address')->nullable();
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
