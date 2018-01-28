<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SysProbIdColumnFix extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */

	public function up()
	{
		DB::statement('ALTER TABLE sysProb modify COLUMN id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
