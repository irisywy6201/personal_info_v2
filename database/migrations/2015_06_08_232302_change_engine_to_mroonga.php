<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeEngineToMroonga extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement('ALTER TABLE faq ENGINE=Mroonga');
		
		$this->dropRequiredTable();
		$this->createQuestionTable();
		$this->createReplyTable();
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$this->dropRequiredTable();
		$this->createOriginQuestionTable();
		$this->createOriginReplyTable();

		DB::statement('ALTER TABLE faq ENGINE=InnoDB');
	}

	/**
	 * Drop all tables to be refreshed.
	 */
	private function dropRequiredTable()
	{
		Schema::drop('reply');
		Schema::drop('question');
	}

	/**
	 * Create question table with Mroonga engine.
	 */
	private function createQuestionTable()
	{
		Schema::create('question', function(Blueprint $table)
		{
			$table->engine = 'Mroonga';
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
	 * Create the origin question table with InnoDB engine.
	 */
	private function createOriginQuestionTable()
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
	 * Create reply table with Mroonga engine.
	 */
	private function createReplyTable()
	{
		Schema::create('reply', function(Blueprint $table) {
			$table->engine = 'Mroonga';
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
	 * Create the origin reply table with InnoDB engine.
	 */
	private function createOriginReplyTable()
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
}
