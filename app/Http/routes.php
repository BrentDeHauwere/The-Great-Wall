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

	// ---------- INDEX ----------
	// Views - Should depend on the role of the user (walls/sessions) TO DO: redirect
	Route::get('/', 'WallController@index'); // TO DO: create controller

	// ---------- SESSIONS ----------
	// Views
	Route::resource('sessions', 'SessionController');
	Route::resource('moderator', 'ModeratorController',['only' => ['show']]);
	// Actions (performed on a session view)
	Route::post('message/accept','MessageController@accept');
	Route::post('message/decline','MessageController@decline');

	// ---------- BLACKLIST ----------
	// Blacklist - Moderator
	Route::resource('blacklist', 'BlacklistController');

	// ---------- WALLS ----------
	// Views
	Route::resource('wall', 'WallController',['only' => ['index','show']]);
	// Wall - Actions to perform on a wall
	Route::resource('message', 'MessageController',['only' => ['store', 'destroy']]);
	Route::resource('poll', 'PollController',['only' => ['store', 'destroy']]);
	Route::resource('votemessage', 'VoteMessageController',['only' => ['store', 'destroy']]);
	Route::resource('votepoll', 'VotePollController',['only' => ['store', 'destroy']]);

	Route::post('wall/enter','WallController@enterWallWithPassword');

});

Route::group(['prefix' => 'api', 'middleware' => ['web']], function () {
	Route::get('walls', 'ApiController@walls');
	Route::get('messages', 'ApiController@messages');
	Route::get('polls', 'ApiController@polls');
	Route::get('blacklist', 'ApiController@blacklist');
});
