<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePasswordChecksumAndEncodePasswordTypeChange extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement('alter table changePassword modify checksum varchar(100) not null');
		DB::statement('alter table changePassword modify encodePassword varchar(1000) not null');
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
