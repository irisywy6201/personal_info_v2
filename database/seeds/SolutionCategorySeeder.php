<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SolutionCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dbInsert = DB::table('solution');
        $dbArray = ['按Wiki提供方法解決',
                    '轉接終端機室工讀生',
                    '轉接行政大樓工讀生',
                    '轉介負責人或中心同仁',
                    '代為註冊問題到Mantis',
                    '找人',
                    '其它',
                    '非電算中心業務'];

        foreach ($dbArray as $value) {
          $dbInsert->insert([
              'method' => $value,
              'visible' => 1,
              'created_at'=>Carbon::now(),
              'updated_at'=>Carbon::now(),
          ]);
        }
    }
}
