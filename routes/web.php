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
    Route::get('thread/{thread}/setFiled', 'ThreadController@setFiled')->name('thread.setFiled');
    Route::get('thread/{thread}/setGood', 'ThreadController@setGood')->name('thread.setGood');
    Route::get('thread/{thread}/setTop', 'ThreadController@setTop')->name('thread.setTop');
    Route::get('thread/{thread}/cancelFiled', 'ThreadController@cancelFiled')->name('thread.cancelFiled');
    Route::get('thread/{thread}/cancelGood', 'ThreadController@cancelGood')->name('thread.cancelGood');
    Route::get('thread/{thread}/cancelTop', 'ThreadController@cancelTop')->name('thread.cancelTop');

    // 用户路由
    Route::get('user/{user}/center', 'UserController@center')->name('user.center');
    Route::get('user/{user}/threads', 'UserController@threads')->name('user.threads');
    Route::get('user/register', 'UserController@register')->name('user.register');
    Route::post('user/register', 'UserController@create')->name('user.create');
    Route::put('user/register', 'UserController@update')->name('user.update');
    Route::get('user', 'UserController@index')->name('user.index');
    Route::get('user/{user}/upgrade', 'UserController@upgrade')->name('user.upgrade');
    Route::get('user/{user}/password', 'UserController@password')->name('user.center.password');
    Route::put('user/{user}/password/set', 'UserController@passwordSet')->name('user.center.password.set');
    Route::get('user/{user}/avatar', 'UserController@avatar')->name('user.center.avatar');
    Route::post('user/{user}/avatar/set', 'UserController@avatarSet')->name('user.center.avatar.set');

    // 板块路由
    Route::get('forum/{forum}', 'ForumController@show')->name('forum.show');
    Route::get('forum', 'ForumController@index')->name('forum.index');
    Route::post('forum', 'ForumController@store')->name('forum.store');
    Route::post('forum/addAdmin', 'ForumController@addAdmin')->name('forum.addAdmin');
    Route::delete('forum', 'ForumController@destroy')->name('forum.destroy');
    Route::put('forum', 'ForumController@update')->name('forum.update');

    // 用户组路由
    Route::get('userGroup', 'UserGroupController@index')->name('userGroup.index');
    Route::post('userGroup', 'UserGroupController@store')->name('userGroup.store');
    Route::post('userGroup/addUser', 'UserGroupController@addUser')->name('userGroup.addUser');
    Route::post('userGroup/addPermission', 'UserGroupController@addPermission')->name('userGroup.addPermission');
    Route::delete('userGroup', 'UserGroupController@destroy')->name('userGroup.destroy');
    Route::put('userGroup', 'UserGroupController@update')->name('userGroup.update');

    // 标签组路由
    Route::post('tagGroup', 'TagGroupController@store')->name('tagGroup.store');
    Route::delete('tagGroup/{id}', 'TagGroupController@destroy')->name('tagGroup.destroy');

    // 标签路由
    Route::get('tag', 'TagController@index')->name('tag.index');
    Route::post('tag', 'TagController@store')->name('tag.store');
    Route::delete('tag/{tag}', 'TagController@destroy')->name('tag.destroy');

    // 评论路由
    Route::resource('reply', 'ReplyController')->except(['index', 'show', 'create', 'edit']);
});
