<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AllFullTextIndexToMroongaTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Add Full-text index to question table.
		DB::statement('ALTER TABLE question ADD FULLTEXT(title)');
		DB::statement('ALTER TABLE question ADD FULLTEXT(content)');
		DB::statement('ALTER TABLE question ADD FULLTEXT INDEX search_question(title, content)');

		// Add Full-text index to reply table.
		DB::statement('ALTER TABLE reply ADD FULLTEXT(content)');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		// Drop Full-text index from question table.
		Schema::table('question', function($table)
		{
			$table->dropIndex('title');
			$table->dropIndex('content');
			$table->dropIndex('search_question');
		});

		// Drop Full-text index from reply table.
		Schema::table('reply', function($table)
		{
			$table->dropIndex('content');
		});
	}

}
