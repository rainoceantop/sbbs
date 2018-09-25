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

Auth::routes();
// 覆盖掉原先的注册路由
Route::get('register', function(){
    return abort(404);
});

Route::get('/', 'ThreadController@index');

Route::group(['middleware'=>'auth'], function(){

    // 帖子路由
    Route::resource('thread', 'ThreadController')->except(['index', 'update']);
    Route::put('thread', 'ThreadController@store')->name('thread.update');

    // 用户路由
    Route::get('user/{user}/center', 'UserController@center')->name('user.center');
    Route::get('user/{user}/threads', 'UserController@threads')->name('user.threads');
    Route::get('user/register', 'UserController@register')->name('user.register');
    Route::post('user/register', 'UserController@create')->name('user.create');
    Route::put('user/register', 'UserController@update')->name('user.update');
    Route::get('user', 'UserController@index')->name('user.index');

    // 板块路由
    Route::get('forum/{forum}', 'ForumController@show')->name('forum.show');
    Route::get('forum', 'ForumController@index')->name('forum.index');
    Route::post('forum', 'ForumController@store')->name('forum.store');
    Route::delete('forum', 'ForumController@destroy')->name('forum.destroy');

    // 用户组路由
    Route::get('userGroup', 'UserGroupController@index')->name('userGroup.index');
    Route::post('userGroup', 'UserGroupController@store')->name('userGroup.store');
    Route::post('userGroup/addUser', 'UserGroupController@addUser')->name('userGroup.addUser');
    Route::post('userGroup/addPermission', 'UserGroupController@addPermission')->name('userGroup.addPermission');
    Route::delete('userGroup', 'UserGroupController@destroy')->name('userGroup.destroy');

    // 标签组路由
    Route::post('tagGroup', 'TagGroupController@store')->name('tagGroup.store');
    Route::delete('tagGroup/{id}', 'TagGroupController@destroy')->name('tagGroup.destroy');

    // 标签路由
    Route::get('tag', 'TagController@index')->name('tag.index');
    Route::post('tag', 'TagController@store')->name('tag.store');

    // 评论路由
    Route::resource('reply', 'ReplyController')->except(['index', 'show', 'create', 'edit']);
});
