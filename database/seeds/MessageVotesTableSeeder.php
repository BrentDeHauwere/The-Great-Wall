<?php

use Illuminate\Database\Seeder;

class MessageVotesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('message_votes')->insert([
            ['message_id' => 1, 'user_id' => 1],
            ['message_id' => 2, 'user_id' => 2],
            ['message_id' => 1, 'user_id' => 3],
            ['message_id' => 3, 'user_id' => 1]
        ]);
    }
}
