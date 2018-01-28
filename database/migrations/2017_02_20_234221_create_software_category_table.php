<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoftwareCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('software_category',function(Blueprint $table)
	{
		$table->increments('id');
		$table->char('category_name_zh',20);
		$table->char('category_name_en',20);
		$table->softDeletes();
	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('software_category');
    }
}
