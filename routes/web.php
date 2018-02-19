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
        Route::get('/general', ['uses' => 'ListController@general', 'as' => 'dashboard.general']);
        Route::get('/filters', ['uses' => 'ListController@filters', 'as' => 'dashboard.filters']);
    });

    /* API Pipefy */
    Route::group(['prefix' => 'api'], function () {
        Route::get('/getCardsUserTable/{userId}', ['uses' => 'ApiPipefyController@getCardsUserTable', 'as' => 'api.get_cards_user_id']);

        Route::get('/getCardsUser/{userId}', ['uses' => 'ApiPipefyController@getCardsUser', 'as' => 'api.get_cards_user']);

        Route::get('/getCardsFilter/{filter_id?}', ['uses' => 'ApiPipefyController@getCardsFilter', 'as' => 'api.get_cards_filter']);

        /* Cards */
        Route::group(['prefix' => 'card'], function () {
            Route::get('/detail/{cardId}', ['uses' => 'CardController@detailCard', 'as' => 'api.cards.detail']);
            Route::post('/comment', ['uses' => 'CardController@comment', 'as' => 'api.cards.comment']);
        });
    });

    /* Configs */
    Route::group(['prefix' => 'config'], function(){
        /* Pipes */
        Route::group(['prefix' => 'pipes'], function(){
            Route::get('/', ['uses' => 'ConfigController@pipes', 'as' => 'config.pipes']);
            Route::post('/save', ['uses' => 'PipeConfigsController@save', 'as' => 'config.pipes.save']);
        });

        /* Filters */
        Route::group(['prefix' => 'filters'], function(){
            Route::get('/', ['uses' => 'FiltersController@filters', 'as' => 'config.filters']);
            Route::get('/insert', ['uses' => 'FiltersController@insert', 'as' => 'config.filters.insert']);
            Route::get('/edit/{filter_id}', ['uses' => 'FiltersController@edit', 'as' => 'config.filters.edit']);
            Route::post('/save', ['uses' => 'FiltersController@save', 'as' => 'config.filters.save']);
            Route::delete('/delete/{filter_id}', ['uses' => 'FiltersController@destroy', 'as' => 'config.filters.destroy']);
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