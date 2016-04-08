<?php

use Illuminate\Database\Seeder;

class PollVotesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('poll_votes')->insert([
            ['choice_id' => 1, 'user_id' => 1],
            ['choice_id' => 1, 'user_id' => 2],
            ['choice_id' => 2, 'user_id' => 3],
            ['choice_id' => 4, 'user_id' => 1],
            ['choice_id' => 5, 'user_id' => 3],
            ['choice_id' => 6, 'user_id' => 1],
        ]);
    }
}
