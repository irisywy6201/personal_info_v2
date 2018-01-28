<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimetypeToLostandfoundTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
	Schema::table('lostandfound',function($table)
	{	
		$table->timestamps();
		$table->timestamp('found_at');
		$table->integer('type_id');
		$table->string('thing_picture1');
		$table->string('thing_picture2')->nullable();
		$table->string('thing_picture3')->nullable();
		$table->string('thing_picture4')->nullable();
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

    }
}
