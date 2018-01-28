<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthsoftindexTable  extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authsoftindex', function (Blueprint $table) {
            $table->increments('id');
			$table->string('indextitle_zh',70)->nullable();
			$table->string('indextitle_en',70)->nullable();			
			$table->text('indexcontent_zh')->nullable();
			$table->text('indexcontent_en')->nullable();
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
        Schema::drop('authsoftindex');
    }
}
