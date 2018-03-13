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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::resource('project',  'Api\ProjectsController');
Route::resource('behavior', 'Api\BehaviorsController');
Route::resource('text',     'Api\TextsController');
Route::resource('icon',     'Api\IconsController');

Route::get('/text/mainmenu/{basemenu}/{projecid}', 'Api\TextsController@mainmenu');

Route::get('/behavior/mainmenu/{basemenu}/{projecid}', 'Api\BehaviorsController@mainmenu');
Route::get('/behavior/animation/{behaviorid}', 'Api\BehaviorsController@animation');
