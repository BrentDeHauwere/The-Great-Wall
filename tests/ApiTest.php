<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiTest extends TestCase
{
    /*
     *  API routes
     *  Route::get('walls', 'ApiController@walls');
		Route::get('messages', 'ApiController@messages');
		Route::get('polls', 'ApiController@polls');
		Route::get('blacklist', 'ApiController@blacklist');
		Route::get('{requestedPage}', 'ApiController@badPage');
     * */

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }
}
