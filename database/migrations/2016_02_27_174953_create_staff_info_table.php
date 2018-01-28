<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Symfony\Component\Console\Output\ConsoleOutput;

class CreateStaffInfoTable extends Migration
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
            Schema::connection('NcuRemoteDB')->create('staff_info', function ($table) {
                $table->increments('id');
                $table->string('personal_no', 10)->nullable();
                $table->string('e_mtype_no', 4)->nullable();
                $table->string('e_stype_no', 4)->nullable();
                $table->string('staff_id', 10)->nullable();
                $table->string('unit_no', 10)->nullable();
                $table->string('tunit_no', 10)->nullable();
                $table->string('title_no', 10)->nullable();
                $table->string('office_rank_no', 5)->nullable();
                $table->string('pay_rank_no', 5)->nullable();
                $table->string('pay_point', 5)->nullable();
                $table->string('fst_arrive_date', 10)->nullable();
                $table->string('org_arrive_date', 10)->nullable();
                $table->string('cur_arrive_date', 10)->nullable();
                $table->string('work_years', 10)->nullable();
                $table->string('work_status_no', 2)->nullable();
                $table->string('work_srn_no', 2)->nullable();
                $table->string('portal_id', 100)->nullable();
                $table->string('portal_pwd', 250)->nullable();
                $table->text('memo', 8)->nullable();
                $table->date('modify_date')->nullable();
            });
        }
        else {
            $this->console->writeln('Migration "create_staff_info_table" will not be executed: Not in "local" environment.');
            $this->console->writeln('Warning: Migration "create_staff_info_table" still recorded by Laravel!');
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
            if (Schema::connection('NcuccOffdutyDB')->hasTable('staff_info')) {
                Schema::connection('NcuRemoteDB')->drop('staff_info');
            }
            else {
                $this->console->writeln('Table "staff_info" not found, no table dropped.');
            }
        }
        else {
            $this->console->writeln('Migration "create_staff_info_table" will not be executed: Not in "local" environment.');
            $this->console->writeln('Warning: Migration "create_staff_info_table" still recorded by Laravel!');
        }
    }
}
