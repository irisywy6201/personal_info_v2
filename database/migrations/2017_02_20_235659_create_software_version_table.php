<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoftwareVersionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('software_version',function(Blueprint $table){
		$table->increments('id');
		$table->integer('platform_id');
		$table->integer('software_list_id');
		$table->integer('surplus');
		$table->text('download_link');
		$table->text('document_link');
		$table->softDeletes();
		
	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('software_version');
    }
}
