<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('question', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('category_id')->unsigned();
			$table->tinyInteger('identity')->unsigned();
			$table->integer('department')->unsigned();
			$table->String('title');
			$table->text('content');
			$table->integer('reply')->Default(0)->unsigned();
			$table->integer('status')->Default(0)->unsigned();
			$table->boolean('isRead')->default(false);
			$table->integer('count')->Default(0)->unsigned();
			$table->boolean('isHidden')->default(false);
			$table->timestamps();

			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('category_id')->references('id')->on('category');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('question');
	}

}
