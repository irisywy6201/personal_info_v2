<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoccatagoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Doccatagory', function (Blueprint $table) {
            $table->increments('id');
			$table->string('doccategory_name_zh', 70)->nullable();
			$table->string('doccategory_name_en', 70)->nullable();
			$table->text('doccategory_discribe_zh')->nullable();
			$table->text('doccategory_discribe_en')->nullable();			
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
        Schema::drop('Doccatagory');
    }
}
