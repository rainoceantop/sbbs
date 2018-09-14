<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('threads', 'ThreadController@index')->name('getThreads');
Route::get('thread/{thread}', 'ThreadController@get')->name('getThread');
Route::post('thread', 'ThreadController@store')->name('addThread');
Route::put('thread', 'ThreadController@store')->name('updThread');
Route::delete('thread/{thread}', 'ThreadController@destroy')->name('delThread');
