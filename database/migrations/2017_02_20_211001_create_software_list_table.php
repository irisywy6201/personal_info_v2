<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoftwareListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('software_list', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('software_category_id')->nullable();
			$table->integer('officeDoc_id')->nullable();
			$table->string('name_zh', 70)->nullable();
			$table->string('name_en', 70)->nullable();
			$table->string('summary_zh', 70)->nullable();
			$table->string('summary_en', 70)->nullable();
			$table->string('kms_link', 70)->nullable();
			$table->integer('year')->nullable();
			$table->integer('isdelete')->nullable();
		
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('software_list');
    }
	
	public function integer($column, $autoIncrement = false, $unsigned = false)
	{
		return $this->addColumn('integer', $column, compact('autoIncrement', 'unsigned'));
	}
}
