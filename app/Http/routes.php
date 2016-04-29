<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
	Route::get('/', 'WallController@index');
	Route::resource('sessions', 'SessionController');
	Route::resource('blacklist', 'BlacklistController');
	Route::post('message/accept','MessageController@accept');
	Route::post('message/decline','MessageController@decline');
	Route::resource('message', 'MessageController',['only' => ['store', 'destroy']]);
	Route::resource('poll', 'PollController',['only' => ['store', 'destroy']]);
	Route::resource('votemessage', 'VoteMessageController',['only' => ['store', 'destroy']]);
	Route::resource('votepoll', 'VotePollController',['only' => ['store', 'destroy']]);
	Route::resource('moderator', 'ModeratorController',['only' => ['show']]);
	Route::post('wall/enter','WallController@enterWallWithPassword');
	Route::resource('wall', 'WallController',['only' => ['index','show']]);

	/*Route::get('wall/{wall_id}','WallController@openWall');
	Route::post('message/new','WallController@newMessage');
	Route::post('message/vote','WallController@voteMessage');
	Route::post('poll/vote','WallController@votePoll');
	Route::get('moderator/questions/{wall_id}','WallController@ModeratorQuestions');
	Route::post('moderator/message/accept','WallController@ModeratorAccept');
	Route::post('moderator/message/decline','WallController@ModeratorDecline');
	Route::post('/wall/enter','WallController@enterWallWithPassword');
	Route::get('/', 'WallController@index');*/
});

Route::group(['prefix' => 'api', 'middleware' => ['web']], function () {
	Route::get('walls', 'ApiController@walls');
	Route::get('messages', 'ApiController@messages');
	Route::get('polls', 'ApiController@polls');
	Route::get('blacklist', 'ApiController@blacklist');
});
