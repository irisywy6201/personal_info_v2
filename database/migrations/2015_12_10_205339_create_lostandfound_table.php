<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLostandfoundTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lostandfound',function(Blueprint $table)
	{
		$table->increments('id');
		$table->boolean('status')->default(false);
		$table->string('description',100);
		$table->string('location',20);
		$table->string('reco_acct')->nullable();
		$table->string('reco_name')->nullable();
		$table->string('reco_email')->nullable();
		$table->integer('reco_phone')->nullable();
	});

	DB::statement('ALTER TABLE lostandfound ADD FULLTEXT(description)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	Schema::table('lostandfound',function($table){
		$table->dropIndex('description');
	});
	
        Schema::drop('lostandfound');
    }
}
