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
			Route::get('session/multiple', 'SessionController@multiple');
			Route::get('session/showMultiple', 'SessionController@showMultiple');
			Route::resource('session', 'SessionController');
			Route::post('session/{id}/revertDestroy', 'SessionController@revertDestroy');
			// Actions (performed on a session view)
			Route::post('message/accept', 'MessageController@accept');
			Route::post('message/decline', 'MessageController@decline');
			Route::post('poll/accept', 'PollController@accept');
			Route::post('poll/decline', 'PollController@decline');
			Route::post('pollchoice/accept', 'PollChoiceController@accept');
			Route::post('pollchoice/decline', 'PollChoiceController@decline');

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

		// ---------- WALL IMAGES ----------
		Route::get('wall_images/{filename}', function ($filename)
		{
			$path = storage_path() . '/app/wall_images/' . $filename;

			$paths = glob($path . '.*');
			if (count($paths) == 1)
			{
				$path = $paths[0];
			}

			if(!File::exists($path))
			{
				$path = storage_path() . '/app/wall_images/' . 'none.png';
			}

			$file = File::get($path);
			$type = File::mimeType($path);

			$response = Response::make($file, 200);
			$response->header("Content-Type", $type);

			return $response;
		})->name('wall_images');;

		// ----------- USER ----------
		Route::post('user/twitterHandle', 'UserController@twitterHandle');
		Route::post('user/image', 'UserController@image');
		Route::get('user/posts', 'UserController@showPosts');

		// ---------- USER IMAGES ----------
		Route::get('user_images/{filename}', function ($filename)
		{
			$path = storage_path() . '/app/user_images/' . $filename;

			$paths = glob($path . '.*');
			if (count($paths) == 1)
			{
				$path = $paths[0];
			}

			if(!File::exists($path))
			{
				$path = storage_path() . '/app/user_images/' . 'none.png';
			}

			$file = File::get($path);
			$type = File::mimeType($path);

			$response = Response::make($file, 200);
			$response->header("Content-Type", $type);

			return $response;
		})->name('user_images');
	});

	Route::group(['prefix' => 'api', 'middleware' => ['web']], function () {
		Route::get('walls', 'ApiController@walls');
		Route::get('messages', 'ApiController@messages');
		Route::get('polls', 'ApiController@polls');
		Route::get('blacklist', 'ApiController@blacklist');
		Route::get('{requestedPage}', 'ApiController@badPage');
	});
});
