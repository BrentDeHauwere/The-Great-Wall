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
        DB::table('message_votes')->insert([]);
    }
}
