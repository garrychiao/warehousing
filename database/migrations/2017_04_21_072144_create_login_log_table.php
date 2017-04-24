<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoginLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('login_log', function (Blueprint $table) {
          $table->increments('id');
          $table->boolean('login_status');
          $table->integer('user_id')->nullable();
          $table->string('ip');
          $table->string('iso_code')->nullable();
          $table->string('country')->nullable();
          $table->string('city')->nullable();
          $table->string('state')->nullable();
          $table->string('state_name')->nullable();
          $table->string('postal_code')->nullable();
          $table->float('lat')->nullable();
          $table->float('lon')->nullable();
          $table->string('timezone')->nullable();
          $table->string('continent')->nullable();
          $table->string('currency')->nullable();
          $table->dateTime('datetime');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('login_log');
    }
}
