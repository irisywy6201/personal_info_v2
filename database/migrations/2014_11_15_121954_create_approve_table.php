<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApproveTable extends Migration {

	/**
	 * Run the migrations. 
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('approve', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('birthday');
			$table->string('idNumber');
			$table->integer('studentId');
			$table->string('cardFront');
			$table->string('cardBack');
			$table->string('approveBy');
			$table->boolean('approved');
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
		Schema::drop('approve');

	}

}

