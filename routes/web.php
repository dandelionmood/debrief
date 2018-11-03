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

use App\Universe;

Auth::routes();
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::post('file-upload', 'FileUploadController@create')->name('file-upload');

    Route::resource('universes', 'UniverseController');

    Route::get('universes/{universe_id}/stories/search', 'SearchController@story')->name('universes.stories.search');
    Route::get('universes/{universe_id}/people/search', 'SearchController@person')->name('universes.people.search');

    Route::get('universes/{universe_id}/stories/tree', 'StoryTreeController@index')->name('universes.stories-tree.index');
    Route::put('universes/{universe_id}/stories/tree/update', 'StoryTreeController@update')->name('universes.stories-tree.update');

    Route::get('universes/{universe_id}/stories/diary/{date}', 'DiaryController@show')
        ->name('universes.stories.diary.date');

    Route::get('universes/{universe_id}/stories/add', 'StoryController@add')
        ->name('universes.stories.add');
    Route::resource('universes.stories', 'StoryController')->except(['create', 'edit']);

    Route::resource('universes.stories.comments', 'CommentController');
    Route::resource('universes.people', 'PeopleController')->only(['show', 'update']);

});