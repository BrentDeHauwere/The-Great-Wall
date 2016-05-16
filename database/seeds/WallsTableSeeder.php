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
            ['user_id' => 3, 'name' => 'Talk Laravel', 'description' => null, 'open_until' => date('Y-m-d H:i:s', time() - (24 * 60 * 60))],
            ['user_id' => 6, 'name' => 'Talk Economic Risks', 'description' => null, 'open_until' => null],
            ['user_id' => 7, 'name' => 'How to secure a server', 'description' => 'During this talk we will explain how to secure a server. If you are interested, don\'t hesitate and visit us.', 'open_until' => date('Y-m-d H:i:s', time() + (7 * 24 * 60 * 60))],
        ]);

        DB::table('walls')->insert([
            ['user_id' => 3, 'name' => 'Talk Protect Yourself', 'password' => Hash::make('test')],
        ]);

        DB::table('walls')->insert([
            ['user_id' => 7, 'name' => 'YouTube for dummies', 'description' => 'We will talk about YouTube. We will explain how to use it. It will be very nice.', 'password' => Hash::make('test'), 'open_until' => date('Y-m-d H:i:s', time() + (7 * 24 * 60 * 60))],
        ]);

        DB::table('walls')->insert([
            ['user_id' => 6, 'name' => 'Ehb Main Wall', 'description' => null, 'open_until' => null, 'hashtag' => 'ehackb'],
        ]);
    }
}
