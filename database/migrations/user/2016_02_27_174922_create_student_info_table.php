<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Symfony\Component\Console\Output\ConsoleOutput;

class CreateStudentInfoTable extends Migration
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
            Schema::connection('NcuRemoteDB')->create('student_info', function ($table) {
                $table->increments('id');
                $table->string('personal_no', 10)->nullable();
                $table->string('s_id', 10)->nullable();
                $table->string('study_system_no', 1)->nullable();
                $table->string('degree_kind_no', 4)->nullable();
                $table->string('did_group', 2)->nullable();
                $table->string('grad_now', 2)->nullable();
                $table->string('s_status', 1)->nullable();
                $table->string('s_now', 2)->nullable();
                $table->string('i_reason', 2)->nullable();
                $table->string('i_semester', 4)->nullable();
                $table->string('i_year', 6)->nullable();
                $table->integer('study_sems')->nullable();
                $table->integer('rest_sems')->nullable();
                $table->integer('delay_graduate')->nullable();
                $table->string('parent_name', 20)->nullable();
                $table->string('parent_rela', 10)->nullable();
                $table->string('parent_add', 255)->nullable();
                $table->string('parent_phone', 20)->nullable();
                $table->string('office_phone', 20)->nullable();
                $table->string('dorm_phone', 20)->nullable();
                $table->string('dorm_address', 250)->nullable();
                $table->string('portal_id', 100)->nullable();
                $table->string('portal_pwd', 250)->nullable();
                $table->string('student_kind_no', 1)->nullable();
                $table->date('modify_date')->nullable();
            });
        }
        else {
            $this->console->writeln('Migration "create_student_info_table" will not be executed: Not in "local" environment.');
            $this->console->writeln('Warning: Migration "create_student_info_table" still recorded by Laravel!');
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
            if (Schema::connection('NcuccOffdutyDB')->hasTable('student_info')) {
                Schema::connection('NcuRemoteDB')->drop('student_info');
            }
            else {
                $this->this->console->writeln('Table "student_info" not found, no table dropped.');
            }
        }
        else {
            $this->console->writeln('Migration "create_student_info_table" will not be executed: Not in "local" environment.');
            $this->console->writeln('Warning: Migration "create_student_info_table" still recorded by Laravel!');
        }
    }
}
