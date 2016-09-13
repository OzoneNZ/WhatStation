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

/**
 *  Frequency controller
 */
Route::group([ 'prefix' => 'frequencies' ], function () {
    Route::get('/{region}', 'FrequencyController@region');
});


/**
 *  Genre controller
 */
Route::get('genres', 'GenreController@genres');


/**
 *  Region controller
 */
Route::get('regions', 'RegionController@regions');


/**
 *  Station controller
 */
Route::group([ 'prefix' => 'stations' ], function () {
    Route::get('/', 'StationController@stations');
    Route::get('/{station}', 'StationController@station');
});


/**
 *  Statistics controller
 */
Route::get('statistics', 'StatisticsController@statistics');
