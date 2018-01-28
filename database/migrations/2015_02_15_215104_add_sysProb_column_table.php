<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSysProbColumnTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('sysProb', function($table)
		{
		    $table->boolean('isSolved')->default(false);
		    $table->integer('solvedBy')->default(null);
		    $table->string('solvedComment');
		    $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('sysProb', function($table)
		{
		  	$table->dropColumn('isSolved');
		  	$table->dropColumn('solvedBy');
		  	$table->dropColumn('solvedComment');
		   	$table->dropTimestamps();
		});
	}

}
