<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NewApproveIdColumnOnChangePasswordTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('changePassword', function($table) {
		    $table->string('approved_id', 10);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('changePassword', function($table)
		{
		    $table->dropColumn('approved_id');
		});
	}

}
