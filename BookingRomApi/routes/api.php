<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::group([
    'prefix' => 'room'
], function () {
        Route::get('/list', 'Api\RoomController@index');
        Route::post('/store', 'Api\RoomController@store');
});

Route::group([
    'prefix' => 'booking'
], function () {
        Route::get('/now', 'Api\BookingController@create');
        Route::post('/now', 'Api\BookingController@now');
        Route::get('/view','Api\BookingController@show');
        Route::post('/inout','Api\BookingController@inout');
        Route::get('/list','Api\BookingController@index');
});