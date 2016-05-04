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
            'id' => 1,
            'name' => 'El Donaldo',
            'email' => 'donald@thegreatmexicanwa.ll',
            'password' => 'china'
        ]
      [
        'id' => 2,
        'name' => 'The Zodiac Killer',
        'email' => 'notJohn@kusack.com',
        'password' => 'trumpislife'
      ]
      );
    }
}
