<?php

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

Route::group(['prefix' => 'TheGreatWall', 'middleware' => ['web']], function () {
  Route::resource('sessions', 'SessionController');
  Route::get('walls', 'WallsController@index');
	Route::get('wall/{wall_id}','WallController@openWall');
	Route::post('message/new','WallController@newMessage');
	Route::post('message/vote','WallController@voteMessage');
	Route::post('poll/vote','WallController@votePoll');
	Route::get('moderator/questions/{wall_id}','WallController@ModeratorQuestions');
	Route::post('moderator/message/accept','WallController@ModeratorAccept');
	Route::post('moderator/message/decline','WallController@ModeratorDecline');
	Route::post('/wall/enter','WallController@enterWallWithPassword');
	Route::get('/', 'WallsController@index');
	Route::get('/walls/{wall}', 'WallsController@show');
	Route::post('/walls/{wall}/enter', 'WallController@openWall');
});
