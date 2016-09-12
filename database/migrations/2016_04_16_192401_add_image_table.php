<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImageTable extends Migration
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
           $table->dropColumn('img_url');
           $table->string('img_id')->after('website')->nullable();
        });

        Schema::create('image_url', function($table)
          {
            $table->increments('id');
            $table->integer('img_id');
            $table->string('img_url');
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
        //
    }
}
