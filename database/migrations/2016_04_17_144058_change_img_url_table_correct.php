<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeImgUrlTableCorrect extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('image_url', function($table)
          {
            $table->dropColumn('img_id');
            $table->string('img_resource')->after('id')->nullable();
          });
          Schema::table('my_companies', function($table)
            {
              $table->dropColumn('img_resource');
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
