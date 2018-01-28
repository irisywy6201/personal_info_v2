<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToContactPersonPositionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('contact_person_position', function($table)
		{
			$table->dropColumn('role');
			$table->integer('contact_person_roles_id')->unsigned()->nullable()->after('category_id');

			$table->foreign('contact_person_roles_id')->references('id')->on('contact_person_roles');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('contact_person_position', function($table)
		{
			$table->dropForeign('contact_person_position_contact_person_roles_id_foreign');
			$table->renameColumn('contact_person_roles_id', 'role');
		});

		DB::statement('ALTER TABLE contact_person_position MODIFY role TINYINT(3) UNSIGNED NOT NULL');
	}

}