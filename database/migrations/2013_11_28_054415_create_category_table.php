<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
class CreateCategoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('category', function(Blueprint $table)
		{
			$table->increments('id');
			$table->String('name');
			$table->String('name_en');
			$table->String('describe');
			$table->String('describe_en');
			$table->integer('parent_id')->unsigned();
			$table->String('href_abb');
			$table->integer('layer');
			$table->boolean('leaf');
			$table->integer('order');
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
		//
		Schema::drop('category');
	}

}