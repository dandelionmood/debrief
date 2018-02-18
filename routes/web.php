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

    Route::resource('universes', 'UniverseController');
    Route::get('universes/{universe_id}/search', 'SearchController@search')->name('universes.search');

    Route::get('universes/{universe_id}/stories/tree', 'StoryTreeController@index')->name('universes.stories-tree.index');
    Route::put('universes/{universe_id}/stories/tree/update', 'StoryTreeController@update')->name('universes.stories-tree.update');

    Route::resource('universes.stories', 'StoryController');
    Route::resource('universes.stories.comments', 'CommentController');


});