<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
class CreateFaqTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('faq',function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('category');
			$table->integer('leaf');
			$table->String('name');
			$table->String('name_en');
			$table->text('answer');
			$table->text('answer_en');
			$table->integer('popularity');
			$table->timestamps();
		});
		
		DB::statement('ALTER TABLE faq ADD FULLTEXT(name)');
		DB::statement('ALTER TABLE faq ADD FULLTEXT(name_en)');
		DB::statement('ALTER TABLE faq ADD FULLTEXT(answer)');
		DB::statement('ALTER TABLE faq ADD FULLTEXT(answer_en)');
		DB::statement('ALTER TABLE faq ADD FULLTEXT INDEX search_en(name_en, answer_en)');
		DB::statement('ALTER TABLE faq ADD FULLTEXT INDEX search_zh_TW(name, answer)');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('faq', function($table)
		{
			$table->dropIndex('name', 'name_en', 'answer', 'answer_en', 'search_en', 'search_zh_TW');
		});

		Schema::drop('faq');
	}

}