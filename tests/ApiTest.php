<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiTest extends TestCase
{
	/*
	 *  API routes
	 *  Route::get('walls', 'ApiController@walls');
	 *
		Route::get('messages', 'ApiController@messages');
		Route::get('polls', 'ApiController@polls');
		Route::get('blacklist', 'ApiController@blacklist');
		Route::get('{requestedPage}', 'ApiController@badPage');
	 * */

	public function testWalls()
	{
		$this->get('/api/walls')
			->seeJsonStructure([
				'data' => [
					'*' => [
						'name',
						'description',
						'hashtag',
						'created_at',
						'wall_id',
						'creator' => [
							'user_id',
							'name',
						],
					],
				],
			]);
	}

	public function testMessages()
	{
		$this->get('api/messages')
			->seeJsonStructure([
				'data' => [
					'*' => [
						'moderator_id',
						'text',
						'created_at',
						'message_id',
						'creator'  => [
							'user_id',
							'name',
						],
						'votes',
						'question',
						'wall'    => [
							'name',
							'description',
							'hashtag',
							'created_at',
							'wall_id',
							'creator' => [
								'user_id',
								'name',
							]
						]
					]
				]
			]);
	}
}