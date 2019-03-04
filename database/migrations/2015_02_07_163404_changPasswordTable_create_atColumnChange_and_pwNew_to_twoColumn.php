<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangPasswordTableCreateAtColumnChangeAndPwNewToTwoColumn extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement('alter table changePassword modify created_at timestamp not null');
		DB::statement('ALTER TABLE changePassword DROP COLUMN pwNew');
		DB::statement('ALTER TABLE changePassword ADD checksum varchar(3000)');
		DB::statement('ALTER TABLE changePassword ADD encodePassword text');

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
