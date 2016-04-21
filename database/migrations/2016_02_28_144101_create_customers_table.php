<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('chi_name');
            $table->string('eng_name');
            $table->string('email');
            $table->string('phone');
            $table->string('cell_phone');
            $table->smallInteger('contact_zip_code')->unsigned();
            $table->string('contact_address');
            $table->smallInteger('recieve_zip_code')->unsigned();
            $table->string('recieve_address');
            $table->string('EIN');
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
        Schema::drop('customers');
    }
}
