<?php

use Illuminate\Database\Seeder;

class lostTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
	DB::table('lostthing_type')->insert([
		['id' => '1','name' => 'electronics'],
		['id' => '2','name' => 'card'],
		['id' => '3','name' => 'decoration'],
		['id' => '4','name' => 'book'],
		['id' => '5','name' => 'stationary'],
		['id' => '6','name' => 'cloth'],
		['id' => '7','name' => 'bag'],
		['id' => '8','name' => 'others']
	]);
    }
}
