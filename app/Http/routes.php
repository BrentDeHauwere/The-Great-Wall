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
Route::group(['prefix' => 'messagewall','middleware' => ['web']], function () {
    //
    Route::get('questions/{wall_id}','WallController@questions');
    Route::post('message/new','WallController@newMessage');
    Route::post('message/vote','WallController@voteMessage');
    Route::post('poll/vote','WallController@votePoll');
    Route::get('/', 'WallsController@index');
    Route::get('/walls/{wall}', 'WallsController@show');
    Route::get('/walls/{wall}/enter', 'WallsController@enter');
});
