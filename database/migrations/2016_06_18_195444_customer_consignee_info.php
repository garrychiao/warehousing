<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CustomerConsigneeInfo extends Migration
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
          $table->renameColumn('contact_zip_code', 'consignee_name');
          $table->renameColumn('contact_address', 'consignee_contact');
          $table->renameColumn('recieve_zip_code', 'consignee_phone');
          $table->renameColumn('recieve_address', 'consignee_zip');

        });
        Schema::table('customers', function($table)
        {
          
          $table->string('consignee_address')->after('consignee_zip')->nullable();
          $table->string('notify_name')->after('consignee_zip')->nullable();
          $table->string('notify_contact')->after('notify_name')->nullable();
          $table->string('notify_phone')->after('notify_contact')->nullable();
          $table->string('notify_zip')->after('notify_phone')->nullable();
          $table->string('notify_address')->after('notify_zip')->nullable();

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
