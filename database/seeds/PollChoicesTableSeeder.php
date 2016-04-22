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
        $Date1 = '2010-09-17';
        $Date2 = date('Y-m-d', strtotime($Date1 . " + 1 day"));
        DB::table('poll_choices')->insert([
            ['poll_id' => 1, 'text' => 'Ja.','created_at' => $Date1],
            ['poll_id' => 1, 'text' => 'Neen.','created_at' => $Date2],
            ['poll_id' => 2, 'text' => 'Ja.','created_at' => $Date1],
            ['poll_id' => 2, 'text' => 'Neen.','created_at' => $Date2],
            ['poll_id' => 3, 'text' => 'Ja.','created_at' => $Date1],
            ['poll_id' => 3, 'text' => 'Neen.','created_at' => $Date2]
        ]);
    }
}
