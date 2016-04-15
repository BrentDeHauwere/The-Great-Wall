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

Route::get('/', function () {
    return view('welcome');
});

Route::get('walls', 'WallsController@index');

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

Route::group(['prefix' => 'messagewall','middleware' => ['web']], function () {
    Route::get('questions/{wall_id}','WallController@questions');
    Route::post('message/new','WallController@newMessage');
    Route::post('message/vote','WallController@voteMessage');
    Route::post('poll/vote','WallController@votePoll');
    Route::get('moderator/questions/{wall_id}','WallController@ModeratorQuestions');
    Route::post('moderator/message/accept','WallController@ModeratorAccept');
    Route::post('moderator/message/decline','WallController@ModeratorDecline');
});
