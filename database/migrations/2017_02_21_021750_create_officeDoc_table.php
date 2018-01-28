<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfficeDocTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('officeDoc', function (Blueprint $table) {
           	$table->increments('id');
		$table->integer('Software_list_id');
		$table->integer('doccatagory_id');
		$table->string('title_zh',100);
		$table->string('title_en',100);
		$table->text('Content_zh');
		$table->text('Content_en');
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
        Schema::drop('officeDoc');
    }
}
