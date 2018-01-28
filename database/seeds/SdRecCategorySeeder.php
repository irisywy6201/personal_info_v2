<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SdRecCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dbInsert = DB::table('sdRecCategory');
        $dbArray = ['電算中心'=>0,
                    'E-mail收送信設定問題'=>1,
                    'CA授權問題、領取光碟'=>1,
                    'E-mail帳號問題、申請'=>1,
                    '電子公文系統'=>1,
                    '辦理離職手續'=>1,
                    '電腦教室問題(含開門)'=>1,
                    '轉接或找人'=>1,
                    '宿網問題'=>1,
                    '其它(問路、桃園區網、....)'=>1,
                    'VoIP網路電話'=>1,
                    '無線網路、行政單位網路'=>1,
                    'VPN'=>1,
                    '電子表單'=>1,
                    'LMS系統'=>1,
                    'Moodle系統'=>1,
                    'Portal入口問題'=>1,
                    'DNS註冊申請'=>1,
                    '硬體設備問題'=>1,
                    '選課系統'=>1];

        foreach ($dbArray as $key => $value) {
          $dbInsert->insert([
              'name'=>$key,
              'parent_id'=>$value,
              'visible' => 1,
              'created_at'=>Carbon::now(),
              'updated_at'=>Carbon::now(),
          ]);
        }
    }
}
