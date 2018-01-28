<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('acct', 128)->unique();
			$table->string('username', 36)->nullable()->default(null);
			$table->integer('role')->unsigned()->default(0);
			$table->integer('addrole')->unsigned()->default(0);
			$table->boolean('registered')->default(false);
			$table->enum('status', array ('init', 'active', 'resign'))->default('init');
			$table->timestamps();
			$table->string('remember_token', 64)->nullable()->default(null);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
