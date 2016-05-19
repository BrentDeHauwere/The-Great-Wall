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
            ['user_id' => 1, 'poll_id' => 1, 'moderator_id' => null,'text' => 'Ja.','created_at' => $Date1],
            ['user_id' => 1, 'poll_id' => 1, 'moderator_id' => null,'text' => 'Neen.','created_at' => $Date2],
            ['user_id' => 2, 'poll_id' => 2, 'moderator_id' => null,'text' => 'Ja.','created_at' => $Date1],
            ['user_id' => 2, 'poll_id' => 2, 'moderator_id' => null,'text' => 'Neen.','created_at' => $Date2],
            ['user_id' => 3, 'poll_id' => 3, 'moderator_id' => null,'text' => 'Ja.','created_at' => $Date1],
            ['user_id' => 3, 'poll_id' => 3, 'moderator_id' => null,'text' => 'Neen.','created_at' => $Date2]
        ]);
    }
}
