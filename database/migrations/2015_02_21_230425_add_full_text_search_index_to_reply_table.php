<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * This migration file is out-dated. All full-text indexes will
 * be added and dropped in the
 * "2015_06_25_215109_all_full_text_index_to_mroonga_tables.php".
 * However, Laravel do record all migration history. So this file
 * cannot be deleted. If we run $ php artisan migrate:rollback after
 * deleting this file, Laravel will run into and Exception because
 * Laravel is unable to find this migration file while the migration
 * history do remember it. So please leave this file unchanged.
 */
class AddFullTextSearchIndexToReplyTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// DB::statement('ALTER TABLE reply ADD FULLTEXT(content)');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		/*
		Schema::table('reply', function($table)
		{
			$table->dropIndex('content');
		});
		*/
	}

}
