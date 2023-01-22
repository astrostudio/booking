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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', function () {
    return 'API';
});

Route::get('/room', 'RoomController@index');
Route::get('/room/{room}', 'RoomController@get');
Route::post('/room', 'RoomController@post');
Route::put('/room/{room}', 'RoomController@put');
Route::delete('/room/{room}', 'RoomController@delete');

Route::get('/reservation','ReservationController@index');
Route::get('/reservation/vacant','ReservationController@vacant');
Route::get('/reservation/{reservation}','ReservationController@get');
Route::post('/reservation','ReservationController@post');
Route::delete('/reservation/{reservation}','ReservationController@delete');
