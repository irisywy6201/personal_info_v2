<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('email', function(Blueprint $table)
		{
			$table->increments('id')->unique();
			$table->integer('user_id')->unsigned();
			$table->string('address');
			$table->string('hash', 32)->unique();
			$table->dateTime('due');
			$table->boolean('verified')->default(false);
			$table->timestamps();

			$table->foreign('user_id')->references('id')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('email');
	}

}
