<?php

use Illuminate\Database\Seeder;

class authTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $id = DB::table('users')->insertGetId([
          'acct' => '102502022',
          'username' => 'admin',
          'role' => '5',
          'addrole' => '1024',
          'registered' => '1',
          'status' => 'active'
        ]);
        DB::table('email')->insert([
	  'user_id' => $id,
          'address' => 'a0988358096@gmail.com',
          'verified' => 'true'
        ]);
    }
}
