<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnnouncementTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('announcement', function(Blueprint $table)
		{
			$table->increments('id')->unique();
			$table->string('announceUser');
			$table->string('title');
			$table->string('link');
			$table->boolean('isSticky')->default(false);
			$table->boolean('isLink')->default(false);
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
		Schema::drop('announcement');
	}

}
