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
	Route::get('/', ['as' => 'home', function() {
		// User should be logged in, therefore will have a role
		// Based on the role, we will redirect the user to the correct page
		// TO DO: get the role of the user
		$role = 'Bezoeker';

		switch ($role) {
			case 'Bezoeker':
				return redirect()->action('WallController@index');
				break;
			case 'Moderator':
				return redirect()->action('SessionController@index');
				break;
			default:
				App::abort(401);
				break;
		}
	}]);

	// ---------- SESSIONS ----------
	// Views
	Route::resource('session', 'SessionController');
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
	Route::post('wall/enter','WallController@enterWallWithPassword');
	Route::resource('message', 'MessageController',['only' => ['store', 'destroy']]);
	Route::resource('poll', 'PollController',['only' => ['store', 'destroy']]);
	Route::resource('pollchoice', 'PollChoiceController',['only' => ['store', 'destroy']]);
	Route::resource('votemessage', 'VoteMessageController',['only' => ['store', 'destroy']]);
	Route::resource('votepoll', 'VotePollController',['only' => ['store', 'destroy']]);

});

Route::group(['prefix' => 'api', 'middleware' => ['web']], function () {
	Route::get('walls', 'ApiController@walls');
	Route::get('messages', 'ApiController@messages');
	Route::get('polls', 'ApiController@polls');
	Route::get('blacklist', 'ApiController@blacklist');
});
