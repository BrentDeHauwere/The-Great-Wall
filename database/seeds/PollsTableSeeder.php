<?php

use Illuminate\Database\Seeder;

class PollsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Date1 = '2010-09-17';
        $Date2 = date('Y-m-d', strtotime($Date1 . " + 1 day"));
        DB::table('polls')->insert([
            ['user_id' => 1, 'wall_id' => 1, 'channel_id' => 1, 'question' => 'Vind je Laravel leuk?', 'addable' => false,'created_at' => $Date1],
            ['user_id' => 2, 'wall_id' => 1, 'channel_id' => 1, 'question' => 'Ken je Laravel?', 'addable' => false,'created_at' => $Date2],
            ['user_id' => 3, 'wall_id' => 2, 'channel_id' => 1, 'question' => 'Ben je op de hoogte van de huidige economie?', 'addable' => false,'created_at' => $Date1]
        ]);
    }
}
