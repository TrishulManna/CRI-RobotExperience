<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'ProjectsController@index');
Auth::routes();

Route::get('/home', 'HomeController@index');
Route::resource('projects', 'ProjectsController');
Route::resource('texts', 'TextsController');
Route::resource('behaviors', 'BehaviorsController');
Route::resource('icons', 'IconsController');
Route::resource('robots', 'RobotsController');

Route::get('/icons/{project_id}/link/', 'IconsController@link')->name('icons.link');
Route::post('/icons/savelink/', 'IconsController@savelink')->name('icons.savelink');
Route::post('/icons/saveicon/', 'IconsController@saveIcon')->name('icons.saveicon');
Route::post('/icons/icon/', 'IconsController@icon')->name('icons.geticon');

Route::delete('/projects/deleteicon/{icon_id}/{project_id}', 'ProjectsController@deleteIcon')->name('projects.deleteicon');

Route::get('/robots/{project_id}/link/', 'RobotsController@link')->name('robots.link');
Route::post('/robots/savelink/', 'RobotsController@savelink')->name('robots.savelink');
Route::post('/robots/getrobot/', 'RobotsController@getrobot')->name('robots.getrobot');

Route::get('/behaviors/{project_id}/link/', 'BehaviorsController@link')->name('behaviors.link');
Route::post('/behaviors/savelink/', 'BehaviorsController@savelink')->name('behaviors.savelink');
Route::get('/behaviors/{behavior_id}/icons/', 'BehaviorsController@icons')->name('behaviors.icons');
Route::post('/behaviors/saveicon/', 'BehaviorsController@saveicon')->name('behaviors.saveicon');
Route::post('/behaviors/savevideo/', 'BehaviorsController@savevideo')->name('behaviors.savevideo');

Route::delete('/projects/deletebehavior/{behavior_id}/{project_id}', 'ProjectsController@deleteBehavior')->name('projects.deletebehavior');

Route::get('/texts/{project_id}/link/', 'TextsController@link')->name('texts.link');
Route::post('/texts/savelink/', 'TextsController@savelink')->name('texts.savelink');
Route::get('/texts/{text_id}/icons/', 'TextsController@icons')->name('texts.icons');
Route::post('/texts/saveicon/', 'TextsController@saveicon')->name('texts.saveicon');

Route::delete('/projects/deletetext/{text_id}/{project_id}', 'ProjectsController@deleteText')->name('projects.deletetext');

Route::get('/projects/{project_id}/change/', 'ProjectsController@change')->name('projects.change');
Route::post('/projects/image/', 'ProjectsController@image')->name('projects.image');
Route::get('/projects/{project_id}/copy/', 'ProjectsController@copy')->name('projects.copy');

Route::get('/behaviors/{project_id}/reorder/', 'BehaviorsController@reorder')->name('behaviors.reorder');
Route::get('/texts/{project_id}/reorder/', 'TextsController@reorder')->name('texts.reorder');

Route::get('/projects/{project_id}/projectdata', 'ProjectsController@projectdata')->name('projects.projectdata');

