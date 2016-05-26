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
        DB::table('poll_votes')->insert([]);
    }
}
