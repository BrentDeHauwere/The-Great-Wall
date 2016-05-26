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
        DB::table('blacklists')->insert([]);
    }
}
