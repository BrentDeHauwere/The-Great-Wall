<?php

use Illuminate\Database\Seeder;

class WallsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('walls')->insert([
            ['user_id' => 1, 'name' => 'Talk Laravel', 'open_until' => date('Y-m-d H:i:s', time() - (24 * 60 * 60))],
            ['user_id' => 2, 'name' => 'Talk Economic Risks', 'open_until' => null]
        ]);

        DB::table('walls')->insert([
            ['user_id' => 2, 'name' => 'Talk Protect Yourself', 'password' => Hash::make('test')]
        ]);
    }
}
