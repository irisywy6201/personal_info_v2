<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Symfony\Component\Console\Output\ConsoleOutput;

class CreateBasicinfoTable extends Migration
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
            Schema::connection('NcuRemoteDB')->create('basicinfo', function ($table) {
                $table->increments('id');
                $table->string('personal_no', 10)->nullable();
                $table->string('cname', 50)->nullable();
                $table->string('ename', 50)->nullable();
                $table->string('sex_no', 1)->nullable();
                $table->string('birthday', 10)->nullable();
                $table->string('nat_no', 5)->nullable();
                $table->string('reg_zip', 5)->nullable();
                $table->string('reg_address', 250)->nullable();
                $table->string('reg_phone', 50)->nullable();
                $table->string('ever_zip', 5)->nullable();
                $table->string('ever_address', 250)->nullable();
                $table->string('ever_phone', 50)->nullable();
                $table->string('home_zip', 5)->nullable();
                $table->string('home_address', 250)->nullable();
                $table->string('home_phone', 50)->nullable();
                $table->string('office_zip', 5)->nullable();
                $table->string('office_address', 250)->nullable();
                $table->string('office_phone', 50)->nullable();
                $table->string('mobile_phone', 50)->nullable();
                $table->string('fax', 50)->nullable();
                $table->string('ncu_email', 50)->nullable();
                $table->string('ncu_email_verify', 1)->nullable();
                $table->string('personal_email', 50)->nullable();
                $table->string('personal_email_verify', 50)->nullable();
                $table->integer('email_using_status')->nullable();
                $table->string('post_account_no', 16)->nullable();
                $table->string('official_account_no', 16)->nullable();
                $table->string('lack_personal_no', 1)->nullable();
                $table->string('personal_memo', 1000)->nullable();
                $table->string('staff_portal_id', 20)->nullable();
                $table->date('modify_date')->nullable();
            });
        }
        else {
            $this->console->writeln('Migration "create_basic_info_table" will not be executed: Not in "local" environment.');
            $this->console->writeln('Warning: Migration "create_basic_info_table" still recorded by Laravel!');
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
            if (Schema::connection('NcuccOffdutyDB')->hasTable('basicinfo')) {
                Schema::connection('NcuRemoteDB')->drop('basicinfo');
            }
            else {
                $this->console->writeln('Table "basicinfo" not found, no table dropped.');
            }
        }
        else {
            $this->console->writeln('Migration "create_basic_info_table" will not be executed: Not in "local" environment.');
            $this->console->writeln('Warning: Migration "create_basic_info_table" still recorded by Laravel!');
        }
    }
}
