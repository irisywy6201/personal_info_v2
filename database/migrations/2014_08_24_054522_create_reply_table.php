<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReplyTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reply', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('question_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->text('content');
			$table->timestamps();

			$table->foreign('question_id')->references('id')->on('question');
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
		Schema::drop('reply');
	}

}