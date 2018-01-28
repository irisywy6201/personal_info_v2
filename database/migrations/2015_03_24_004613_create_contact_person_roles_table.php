<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactPersonRolesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contact_person_roles', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name_zh_TW');
			$table->string('name_en');
			$table->text('description_zh_TW');
			$table->text('description_en');
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
		Schema::drop('contact_person_roles');
	}

}
