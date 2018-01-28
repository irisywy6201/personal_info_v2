<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Symfony\Component\Console\Output\ConsoleOutput;

class CreateAcademicsUnitTable extends Migration
{
    private $console;
    function __construct()
    {
        $this->console = new ConsoleOutput();
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
	$console = new ConsoleOutput();
        
        if (app()->environment() == 'local') {
            Schema::connection('NcuRemoteDB')->create('academics_unit', function ($table) {
                $table->increments('id');
                $table->string('degree_kind_no', 4);
                $table->string('degree_kind_cname', 150);
            });
        }
        else {
            $this->console->writeln('Migration "create_academics_unit_table" will not be executed: Not in "local" environment.');
            $this->console->writeln('Warning: Migration "create_academics_unit_table" still recorded by Laravel!');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
	if (app()->environment() == 'local') {
            if (Schema::connection('NcuccOffdutyDB')->hasTable('academics_unit')) {
                Schema::connection('NcuRemoteDB')->drop('academics_unit');
            }
            else {
                $this->this->console->writeln('Table "academics_unit" not found, no table dropped.');
            }
        }
        else {
            $this->console->writeln('Migration "create_academics_unit_table" will not be executed: Not in "local" environment.');
            $this->console->writeln('Warning: Migration "create_academics_unit_table" still recorded by Laravel!');
        }
    }
}
    

