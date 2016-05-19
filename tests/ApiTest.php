<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiTest extends TestCase
{
  /*
   * Tests for each available route.
   * */

    public function testWalls()
    {
        $response = $this->call('GET', '/api/walls');
        $json = json_decode($response->content(), true);

        for ($i = 0; $i < $json['last_page']; $i++) {
            $this->get('/api/walls?page=' . $i)
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
    }
    
    public function testMessages()
    {
        $response = $this->call('GET', '/api/messages');
        $json = json_decode($response->content(), true);

        for ($i = 0; $i < $json['last_page']; $i++) {
            $this->get('api/messages?page=' . $i)
                ->seeJsonStructure([
                    'data' => [
                        '*' => [
                            'moderator_id',
                            'text',
                            'created_at',
                            'message_id',
                            'creator',
                            'votes',
                            'question',
                            'wall' => [
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

    public function testPolls()
    {
        $response = $this->call('GET', '/api/polls');
        $json = json_decode($response->content(), true);

        for ($i = 0; $i < $json['last_page']; $i++) {
            echo $i;
            $this->get('api/polls?page=' . $i)
                ->seeJsonStructure([
                    'data' => [
                        '*' => [
                            'moderator_id',
                            'channel_id',
                            'created_at',
                            'poll_id',
                            'wall' => [
                                'name',
                                'description',
                                'hashtag',
                                'created_at',
                                'wall_id',
                                'creator' => [
                                    'user_id',
                                    'name'
                                ]
                            ],
                            'creator',
                            'text',
                            'options' => [
                                '*' => [
                                    'text',
                                    'votes'
                                ]
                            ]
                        ]
                    ]
                ]);
        }
    }

    public function testBlacklist()
    {
        $response = $this->call('GET', '/api/blacklist');
        $json = json_decode($response->content(), true);

        for ($i = 0; $i < $json['last_page']; $i++) {
            echo $i;
            $this->get('api/blacklist?page=' . $i)
                ->seeJsonStructure([
                    'data' => [
                        '*' => [
                            'id',
                            'reason',
                            'created_at',
                            'user' => [
                                'user_id',
                                'name'
                            ]
                        ]
                    ]
                ]);
        }
    }

    public function testBadPage(){
        $rndstr = str_random(20);

        $this->get('/api/'.$rndstr)
            ->seeJsonEquals([
                'error' => 'URL not found.',
                'error_code' => 404,
                'reason' => 'The requested page '.$rndstr.' could not be found.'
            ]);
    }
}