<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChangePasswordTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('changePassword', function(Blueprint $table)
		{
			$table->increments('id');
			$table->char('schoolID', 10);
			$table->text('pwNew');
			$table->char('stuOrNot', 20);
			$table->date('created_at');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('changePassword');
	}

}
