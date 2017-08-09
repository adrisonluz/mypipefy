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

Route::group(['middleware' => ['web']], function () {
    Route::get('/', ['uses' => 'HomeController@index', 'as' => 'home']);
    Route::get('/home', ['uses' => 'HomeController@index', 'as' => 'home']);
    Route::get('/index', ['uses' => 'HomeController@index', 'as' => 'home']);

    /* Dashboard */
    Route::group(['prefix' => 'dashboard'], function () {
    	Route::get('/', ['uses' => 'ListController@index', 'as' => 'dashboard']);
    	Route::get('/team', ['uses' => 'ListController@team', 'as' => 'dashboard.team']);
	});

    /* API Pipefy */
    Route::group(['prefix' => 'api'], function () {
    	Route::post('/getMe', ['uses' => 'ApiPipefyController@getMe', 'as' => 'api.get_me']);
    	Route::post('/onlyPipes', ['uses' => 'ApiPipefyController@onlyPipes', 'as' => 'api.only_pipes']);
        Route::post('/getCardsUser', ['uses' => 'ApiPipefyController@getCardsUser', 'as' => 'api.get_cards_user']);
	});
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');