<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDynamicLinkTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dynamic_link', function(Blueprint $table)
		{
			$table->increments('id')->unique();
			$table->string('acct', 10)->nullable();
			$table->string('link')->unique();
			$table->string('hash', 32)->unique();
			$table->dateTime('due');
			$table->boolean('varified')->default(false);
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
		Schema::drop('dynamic_link');
	}

}
