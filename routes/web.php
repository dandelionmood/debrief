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

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/locale/{locale}', 'HomeController@changeLocale')->name('change-locale');

    Route::post('file-upload', 'FileUploadController@create')->name('file-upload');

    // User management
    Route::group(['middleware' => 'can:manage-users'], function() {
        Route::resource('users', 'UserController');
        Route::put('users/{user}/restore', 'UserController@restore')->name('users.restore');
    });

    Route::resource('universes', 'UniverseController');

    Route::get('universes/{universe}/stories/search', 'SearchController@story')->name('universes.stories.search');
    Route::get('universes/{universe}/people/search', 'SearchController@person')->name('universes.people.search');
    Route::get('universes/{universe}/tags/search', 'SearchController@tag')->name('universes.tags.search');

    Route::get('universes/{universe}/stories/tree', 'StoryTreeController@index')->name('universes.stories-tree.index');
    Route::put('universes/{universe}/stories/tree/update', 'StoryTreeController@update')->name('universes.stories-tree.update');

    Route::get('universes/{universe}/stories/diary/{date}', 'StoryDiaryController@show_or_create')
        ->name('universes.stories.diary.date');

    Route::get('universes/{universe}/stories/add', 'StoryController@add')
        ->name('universes.stories.add');

    Route::resource('universes.stories', 'StoryController')->except(['create', 'edit']);

    Route::resource('universes.stories.comments', 'CommentController');
    Route::resource('universes.people', 'PeopleController')->only(['show', 'update']);

    Route::resource('universes.tags', 'TagsController')->only(['show', 'update']);

});