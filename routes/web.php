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

Route::get('/', function () {
    return redirect()->route('create_season');
});

Route::prefix('season')->group(function () {
    Route::get('/create', 'SeasonController@create')->name('create_season');
    Route::post('/store', 'SeasonController@store')->name('store_season');
    Route::get('/{id}', 'SeasonController@show')->name('show_season');
    Route::get('/{id}/table', 'SeasonController@getTable')->name('get_season_table');
    Route::get('/{id}/predictions', 'SeasonController@getPredictions')->name('get_season_predictions');
});

Route::prefix('week')->group(function () {
    Route::post('/play', 'WeekController@play')->name('play_week');
});
