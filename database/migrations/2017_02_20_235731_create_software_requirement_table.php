<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoftwareRequirementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('software_requirement',function(Blueprint $table){
		$table->increments('id');
		$table->integer('software_list_id');
		$table->text('requirement_zh');
		$table->text('requirement_en');
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
        Schema::drop('software_requirement');
    }
}
