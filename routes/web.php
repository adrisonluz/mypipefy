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
    /* Auth Google */
    Route::get('/login/google', ['uses' => 'Auth\LoginController@redirectToProvider', 'as' => 'google']);
    Route::get('/login/google/callback', ['uses' => 'Auth\LoginController@handleProviderCallback']);
});

Route::group(['middleware' => ['auth']], function () {
    /* Dashboard */
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/', ['uses' => 'ListController@index', 'as' => 'dashboard']);
        Route::get('/team', ['uses' => 'ListController@team', 'as' => 'dashboard.team']);
    });

    /* API Pipefy */
    Route::group(['prefix' => 'api'], function () {
        Route::get('/getCardsUser/{userId}', ['uses' => 'ApiPipefyController@getCardsUserTable', 'as' => 'api.get_cards_user_id']);
        Route::post('/getCardsUser', ['uses' => 'ApiPipefyController@getCardsUser', 'as' => 'api.get_cards_user']);
        
        /* Cards */
        Route::group(['prefix' => 'card'], function () {
            Route::get('/detail/{userId}', ['uses' => 'CardController@detailCard', 'as' => 'api.cards.detail']);

        });
    });

    /* Configs */
    Route::group(['prefix' => 'config'], function(){
        /* Pipes */
        Route::group(['prefix' => 'pipes'], function(){
            Route::get('/', ['uses' => 'ConfigController@pipes', 'as' => 'config.pipes']);
            Route::post('/save', ['uses' => 'PipeConfigsController@save', 'as' => 'config.pipes.save']);
        });

        Route::get('/team', ['uses' => 'ConfigController@team', 'as' => 'config.team']);
        Route::post('/sendInvite', ['uses' => 'TeamController@sendInvite', 'as' => 'config.sendInvite']);
        Route::post('/removeInvite', ['uses' => 'TeamController@removeInvite', 'as' => 'config.removeInvite']);
        Route::post('/reorder', ['uses' => 'TeamController@reorder', 'as' => 'config.reorder']);
        Route::post('/changeInvite', ['uses' => 'TeamController@changeInvite', 'as' => 'config.changeInvite']);
    });
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');