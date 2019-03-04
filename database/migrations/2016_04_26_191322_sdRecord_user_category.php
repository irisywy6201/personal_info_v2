<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SdRecordUserCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('sdRecUserCategory', function(Blueprint $table)
      {
        $table->increments('id');
        $table->String('user');
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
        Schema::drop('sdRecUserCategory');
    }
}
