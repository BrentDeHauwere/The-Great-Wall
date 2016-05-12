<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('users')->insert([
			['id' => 1, 'name' => 'Brent De Hauwere', 'role' => 'Visitor', 'email' => 'brent@gmail.com', 'password' => 'secret'],
			['id' => 2, 'name' => 'Eli Boey', 'role' => 'Visitor', 'email' => 'eli@gmail.com', 'password' => 'secret'],
			['id' => 3, 'name' => 'Jonas De Pelsmaeker', 'role' => 'Speaker', 'email' => 'jonas@gmail.com', 'password' => 'secret'],
			['id' => 4, 'name' => 'Kamiel Klumpers', 'role' => 'Moderator', 'email' => 'kamiel@gmail.com', 'password' => 'secret'],
		]);
	}
}
