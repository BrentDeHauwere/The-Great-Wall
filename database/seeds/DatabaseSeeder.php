<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BlackListsTableSeeder::class);
        $this->call(ChannelsTableSeeder::class);
        $this->call(MessagesTableSeeder::class);
        $this->call(MessageVotesTableSeeder::class);
        $this->call(PollChoicesTableSeeder::class);
        $this->call(PollsTableSeeder::class);
        $this->call(PollVotesTableSeeder::class);
        $this->call(WallsTableSeeder::class);
    }
}
