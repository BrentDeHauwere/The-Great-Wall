<?php

use Illuminate\Database\Seeder;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Date1 = '2010-09-17';
        DB::table('messages')->insert([
            ['user_id' => 1, 'wall_id' => 1, 'channel_id' => 1, 'text' => 'Ik ben Brent De Hauwere.', 'created_at' => $Date1, 'anonymous' => false],
            ['user_id' => 2, 'wall_id' => 2, 'channel_id' => 2, 'text' => 'Dit bericht komt op de wall.', 'created_at' => date("Y-m-d H:i:s"), 'anonymous' => false],
            ['user_id' => 3, 'wall_id' => 1, 'channel_id' => 1, 'text' => 'Testbericht', 'created_at' => date("Y-m-d H:i:s"), 'anonymous' => true]        ]);

        DB::table('messages')->insert([
            ['user_id' => 1, 'wall_id' => 1, 'channel_id' => 1, 'text' => 'Leuk dat jij Brent heet', 'created_at' => date("Y-m-d H:i:s"), 'anonymous' => false, 'question_id' => 1]
        ]);
    }
}
