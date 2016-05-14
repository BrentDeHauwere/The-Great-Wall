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

Route::group(['middleware' => 'web'], function () {
	// ---------- AUTHENTICATION ----------
	Route::get('login','UserController@index');
	Route::post('login','UserController@login');
	Route::get('logout','UserController@logout');

	Route::group(['middleware' => 'user'], function () {
		// ---------- INDEX ----------
		Route::get('/', ['as' => 'home', function() {
			// User should be logged in, therefore will have a role
			// Based on the role, we will redirect the user to the correct page
			$role = Auth::user()->role;

			switch ($role) {
				case 'Visitor':
					return redirect()->action('WallController@index');
					break;
				case 'Speaker':
					return redirect()->action('WallController@index');
					break;
				case 'Moderator':
					return redirect()->action('SessionController@index');
					break;
				default:
					abort(403);
					break;
			}
		}]);

		Route::group(['middleware' => 'moderator'], function ()
		{
			// ---------- SESSIONS ----------
			// Views
			Route::resource('session', 'SessionController');
			Route::post('session/{id}/revertDestroy', 'SessionController@revertDestroy');
			// Actions (performed on a session view)
			Route::post('message/accept', 'MessageController@accept');
			Route::post('message/decline', 'MessageController@decline');

			// ---------- BLACKLIST ----------
			// Blacklist - Moderator
			Route::resource('blacklist', 'BlacklistController');
		});

		// ---------- WALLS ----------
		// Views
		Route::get('wall/update/{id}','WallController@updateShow');
		Route::resource('wall', 'WallController',['only' => ['index','show']]);
		// Wall - Actions to perform on a wall
		Route::post('wall/enter','WallController@enterWallWithPassword');
		Route::get('wall/update/{id}','WallController@updateShow');
		Route::resource('message', 'MessageController',['only' => ['store', 'destroy']]);
		Route::resource('poll', 'PollController',['only' => ['store', 'destroy']]);
		Route::resource('pollchoice', 'PollChoiceController',['only' => ['store', 'destroy']]);
		Route::resource('votemessage', 'VoteMessageController',['only' => ['store', 'destroy']]);
		Route::resource('votepoll', 'VotePollController',['only' => ['store', 'destroy']]);

		// ----------- USER ----------
		Route::post('twitterHandle', 'UserController@twitterHandle');
	});

	Route::group(['prefix' => 'api', 'middleware' => ['web']], function () {
		Route::get('walls', 'ApiController@walls');
		Route::get('messages', 'ApiController@messages');
		Route::get('polls', 'ApiController@polls');
		Route::get('blacklist', 'ApiController@blacklist');
		Route::get('{requestedPage}', 'ApiController@badPage');
	});
});