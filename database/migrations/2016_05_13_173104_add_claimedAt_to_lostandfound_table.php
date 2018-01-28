<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddClaimedAtToLostandfoundTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lostandfound', function (Blueprint $table) {
            
            $table->timestamp('claimed_at');
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
            
            $table->dropColumn('claimed_at');
        });
    }
}
