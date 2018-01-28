<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SdRecordCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('sdRecCategory', function(Blueprint $table)
      {
        $table->increments('id');
        $table->String('name');
        $table->integer('parent_id')->unsigned();
        $table->integer('visible')->unsigned();
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
        Schema::drop('sdRecCategory');
    }
}
