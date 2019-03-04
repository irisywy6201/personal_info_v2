<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHDDestroyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('HD_destroy', function (Blueprint $table) {
            $table->increments('id');
            $table->string('brandAndStorage', 25);
            $table->string('propertyID', 20);
            $table->string('office', 20);
            $table->string('name', 20);
            $table->integer('extension')->length(10)->unsigned();
            $table->timestamp('appointmentTime');
            $table->string('ps', 20);
	    $table->integer('state')->length(1)->unsigned();
            $table->timestamps('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('HD_destroy');
    }
}
