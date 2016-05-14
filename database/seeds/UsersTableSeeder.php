<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
			['id' => 1, 'name' => 'Brent De Hauwere', 'role' => 'Visitor', 'email' => 'brent@gmail.com', 'password' => Hash::make('secret')],
			['id' => 2, 'name' => 'Eli Boey', 'role' => 'Visitor', 'email' => 'eli@gmail.com', 'password' => Hash::make('secret')],
			['id' => 3, 'name' => 'Jonas De Pelsmaeker', 'role' => 'Speaker', 'email' => 'jonas@gmail.com', 'password' => Hash::make('secret')],
			['id' => 4, 'name' => 'Kamiel Klumpers', 'role' => 'Moderator', 'email' => 'kamiel@gmail.com', 'password' => Hash::make('secret')],
			['id' => 5, 'name' => 'Admin Nistrator', 'role' => 'Moderator', 'email' => 'admin@gmail.com', 'password' => Hash::make('secret')],
		]);
	}
}
