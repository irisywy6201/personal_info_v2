<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SdRecUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $dbInsert = DB::table('sdRecUserCategory');
      $dbArray = ['在校生',
                  '外籍生',
                  '教職員',
                  '外籍教職員',
                  '校外人士',
                  '畢業生及退休人員'
                  ];

      foreach ($dbArray as $value) {
        $dbInsert->insert([
            'user'=>$value,
            'visible'=>1,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ]);
      }
    }
}
