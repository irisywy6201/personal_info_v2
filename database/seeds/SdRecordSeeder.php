<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SdRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $dbIsert = DB::table('sdRecord');
      $a = 1;
      while ($a <= 100) {
        $dbIsert->insert([
            'category'=>rand(2,20),
            'user_category'=>rand(1,6),
            'sdRecCont'=>str_random(100),
            'solution'=>rand(1,8),
            'user_id'=>str_random(8).'@'.str_random(4).'.com',
            'recorder'=>'autoGenerate',
            'user_contact'=>str_random(10),
            'editTime'=>Carbon::now(),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ]);
        $a = $a+1;
      }
    }
}
