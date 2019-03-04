<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoftwareCdCollectionRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('software_cd_collection_record',function(Blueprint $table){
		$table->increments('id');		
		$table->integer('users_id');
		$table->integer('software_version_id');
		$table->softDeletes();
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
	Schema::drop('software_cd_collection_record');
    }
}
