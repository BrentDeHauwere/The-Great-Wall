<?php

use Illuminate\Database\Seeder;

class BlacklistsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('blacklists')->insert([
            'user_id' => 1,
            'reason' => 'Spam',
            'created_at' => date("Y-m-d H:i:s")
        ]);
    }
}
