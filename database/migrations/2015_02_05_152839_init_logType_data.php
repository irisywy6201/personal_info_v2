<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitLogTypeData extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::table('log_type')->insert(
    		array('id' => 0, 'log_type' => 'login'));

    	DB::table('log_type')->insert(
    		array('id' => 1, 'log_type' => 'changePass'));

    	DB::table('log_type')->insert(
    		array('id' => 2, 'log_type' => 'changeMail'));

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
