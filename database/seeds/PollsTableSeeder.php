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
        DB::table('polls')->insert([
            ['wall_id' => 1, 'question' => 'Vind je Laravel leuk?', 'addable' => false],
            ['wall_id' => 1, 'question' => 'Ken je Laravel?', 'addable' => false],
            ['wall_id' => 2, 'question' => 'Ben je op de hoogte van de huidige economie?', 'addable' => false]
        ]);
    }
}
