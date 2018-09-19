<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'ThreadController@index');
Auth::routes();

// thread路由
Route::resource('thread', 'ThreadController')->except(['index', 'update']);
Route::put('thread', 'ThreadController@store')->name('thread.update');

// user路由
Route::get('user/{user}/center', 'UserController@center')->name('user.center');
Route::get('user/{user}/threads', 'UserController@threads')->name('user.threads');

// 板块路由
Route::get('forum/{forum}', 'ForumController@show')->name('forum.show');
Route::get('forum', 'ForumController@index')->name('forum.index');
Route::post('forum', 'ForumController@store')->name('forum.store');

// 标签组路由
Route::post('tagGroup', 'TagGroupController@store')->name('tagGroup.store');
Route::delete('tagGroup/{id}', 'TagGroupController@destroy')->name('tagGroup.destroy');

// 标签路由
Route::get('tag/{tag}', 'TagController@show')->name('tag.show');
Route::post('tag', 'TagController@store')->name('tag.store');