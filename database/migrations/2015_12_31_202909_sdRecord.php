<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SdRecord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('sdRecord', function(Blueprint $table)
      {
        $table->increments('id');
        $table->integer('category');
        $table->integer('user_category');
        $table->text('sdRecCont');
        $table->integer('solution');
        $table->String('recorder');
        $table->String('user_id');
        $table->String('user_contact');
        $table->String('editTime');
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
      Schema::drop('sdRecord');
    }
}
