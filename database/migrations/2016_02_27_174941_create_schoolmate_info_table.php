<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Symfony\Component\Console\Output\ConsoleOutput;

class CreateSchoolmateInfoTable extends Migration
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
        if (app()->environment() == 'local') {
            Schema::connection('NcuRemoteDB')->create('schoolmate_info', function ($table) {
                $table->increments('id');
                $table->string('personal_no', 10)->nullable();
                $table->string('schoolmate_no', 10)->nullable();
                $table->string('s_id', 10)->nullable();
                $table->string('study_system_no', 1)->nullable();
                $table->string('grad_year', 20)->nullable();
                $table->string('degree_kind_no', 4)->nullable();
                $table->string('did_group', 2)->nullable();
                $table->string('grad_now')->nullable();
                $table->string('degree_kind_cname', 254)->nullable();
                $table->string('degree_kind_ename', 254)->nullable();
                $table->string('s_now', 2)->nullable();
                $table->string('other_edu_career', 254)->nullable();
                $table->string('i_reason', 2)->nullable();
                $table->string('i_semester', 4)->nullable();
                $table->string('i_year', 6)->nullable();
                $table->string('leave_no', 40)->nullable();
                $table->string('leave_semester', 4)->nullable();
                $table->string('leave_year', 6)->nullable();
                $table->string('portal_id', 100)->nullable();
                $table->string('portal_pwd', 250)->nullable();
                $table->string('teacher_cname', 100)->nullable();
                $table->text('memo', 8)->nullable();
                $table->date('modify_date')->nullable();
            });
        }
        else {
            $this->console->writeln('Migration "create_schoolmate_info_table" will not be executed: Not in "local" environment.');
            $this->console->writeln('Warning: Migration "create_schoolmate_info_table" still recorded by Laravel!');
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
            if (Schema::connection('NcuccOffdutyDB')->hasTable('schoolmate_info')) {
                Schema::connection('NcuRemoteDB')->drop('schoolmate_info');
            }
            else {
                $this->console->writeln('Table "schoolmate_info" not found, no table dropped.');
            }
        }
        else {
            $this->console->writeln('Migration "create_schoolmate_info_table" will not be executed: Not in "local" environment.');
            $this->console->writeln('Warning: Migration "create_schoolmate_info_table" still recorded by Laravel!');
        }
    }
}
