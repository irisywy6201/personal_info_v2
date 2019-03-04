<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContributorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contributors', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 70)->default(null);
			$table->string('name_en', 70)->default(null);
			$table->text('introduction')->default(null);
			$table->text('introduction_en')->default(null);
			$table->text('job_responsibilities')->default(null);
			$table->text('job_responsibilities_en')->default(null);
			$table->string('profile_picture')->default(null);
			$table->timestamps();
		});

		Schema::create('contributor_positions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name')->default(null);
			$table->string('name_en')->default(null);
			$table->text('detail')->default(null);
			$table->text('detail_en')->default(null);
			$table->timestamps();
		});

		Schema::create('contributor_position_list', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('contributors_id')->unsigned();
			$table->integer('contributor_positions_id')->unsigned();
			$table->timestamps();

			$table->foreign('contributors_id')->references('id')->on('contributors');
			$table->foreign('contributor_positions_id')->references('id')->on('contributor_positions');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contributor_position_list');
		Schema::drop('contributor_positions');
		Schema::drop('contributors');
	}

}
