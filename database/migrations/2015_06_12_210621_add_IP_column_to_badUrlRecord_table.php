<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIPColumnToBadUrlRecordTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('badUrlRecord', function($table)
		{
			$table->string('record_IP', 100);
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
	        $table->dropColumn('record_IP');
	    });
	}

}
