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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('number-to-roman', 'NumeralController@store')->name('store');
Route::get('recently-converted', 'NumeralController@recentlyConverted')->name('recentlyConverted');
Route::get('top-ten', 'NumeralController@topTen')->name('top-ten');
