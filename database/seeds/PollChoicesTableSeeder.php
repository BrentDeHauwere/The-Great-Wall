<?php

use Illuminate\Database\Seeder;

class PollChoicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('poll_choices')->insert([
            ['poll_id' => 1, 'text' => 'Ja.'],
            ['poll_id' => 1, 'text' => 'Neen.'],
            ['poll_id' => 2, 'text' => 'Ja.'],
            ['poll_id' => 2, 'text' => 'Neen.'],
            ['poll_id' => 3, 'text' => 'Ja.'],
            ['poll_id' => 3, 'text' => 'Neen.']
        ]);
    }
}
