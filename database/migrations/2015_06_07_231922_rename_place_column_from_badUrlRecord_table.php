<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenamePlaceColumnFromBadUrlRecordTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('badUrlRecord', function($table)
		{
			$table->renameColumn('place', 'place_symbol');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('badUrlRecord', function($table)
		{
			$table->renameColumn('place_symbol', 'place');
		});
	}

}
