<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPlaceColumnFromBadUrlRecord extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('badUrlRecord', function($table)
		{
			$table->string('place', 10);
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
	        $table->dropColumn('place');
	    });
	}

}
