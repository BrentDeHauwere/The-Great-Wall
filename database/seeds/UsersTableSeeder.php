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
			['id' => 1, 'name' => 'Walter Belgers', 'role' => 'Speaker', 'email' => '1@mail.be', 'password' => Hash::make('secret')],
			['id' => 2, 'name' => 'Inti De Ceukelaire', 'role' => 'Speaker', 'email' => '2@mail.be', 'password' => Hash::make('secret')],
			['id' => 4, 'name' => 'Mathias Craps', 'role' => 'Speaker', 'email' => '3@mail.be', 'password' => Hash::make('secret')],
			['id' => 5, 'name' => 'Dylan Meysmans', 'role' => 'Speaker', 'email' => '4@mail.be', 'password' => Hash::make('secret')],
			['id' => 6, 'name' => 'Jan De Coster', 'role' => 'Speaker', 'email' => '5@mail.be', 'password' => Hash::make('secret')],
			['id' => 7, 'name' => 'EHackB', 'role' => 'Visitor', 'email' => '6@mail.be', 'password' => Hash::make('secret')],
		]);
	}
}
