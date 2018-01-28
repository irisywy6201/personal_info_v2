<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsMilitaryToLostandfoundTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lostandfound', function (Blueprint $table) {
            
	    $table->string('ForwardStatus')->default('default');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lostandfound', function (Blueprint $table) {
            
	    $table->dropColumn('ForwardStatus');
        });
    }
}
