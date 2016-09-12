<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyImgTable extends Migration
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
        $table->dropColumn(array('parent', 'img_resource'));
      });

      Schema::table('image_url', function($table)
      {
        $table->string('inv_id')->nullable()->after('id');
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
