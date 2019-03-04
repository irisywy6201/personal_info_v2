<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Symfony\Component\Console\Output\ConsoleOutput;

class CreateISPEmailTable extends Migration
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
        $console = new ConsoleOutput();
        
        if (app()->environment() == 'local') {
            Schema::connection('NcuccOffdutyDB')->create('ISP_email', function ($table) {
                $table->string('sid', 10);
                $table->string('email', 55);
                $table->string('trans_flag', 1);
                $table->string('up_date', 8);

                $table->primary('sid');
                $table->unique('sid');

                
            });
        }
        else {
            $this->console->writeln('Migration "create_ISP_email_table" will not be executed: Not in "local" environment.');
            $this->console->writeln('Warning: Migration "create_ISP_email_table" still recorded by Laravel!');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (app()->environment() == 'local') {
            if (Schema::connection('NcuccOffdutyDB')->hasTable('ISP_email')) {
                Schema::connection('NcuccOffdutyDB')->drop('ISP_email');
            }
            else {
                $this->console->writeln('Table "ISP_email" not found, no table dropped.');
            }
        }
        else {
            $this->console->writeln('Migration "create_ISP_email_table" will not be executed: Not in "local" environment.');
            $this->console->writeln('Warning: Migration "create_ISP_email_table" still recorded by Laravel!');
        }
    }
}

