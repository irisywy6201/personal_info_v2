<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBadUrlRecordTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('badUrlRecord', function($table)
		{
			$table->increments('id');
			$table->string('schoolID', 20);
			$table->text('url');
			$table->string('floor', 10);
			$table->timestamp('happen_time');
			$table->timestamp('record_time');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('badUrlRecord');
	}

}
