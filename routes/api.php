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
Route::group([],function() {
    Route::middleware('player')->get('/juego/{id}', 'JuegoController@index');
    Route::middleware('player')->get('/winners/{id}', 'JuegoController@getWinners');
    Route::middleware('auth:api')->get('/record', 'JuegoController@record');
    Route::get('/rooms_available', 'JuegoController@indexAvailable');
    Route::get('/rounds', 'JuegoController@getRounds');
    Route::put('/unirse_juego', 'JuegoController@joinRoom');
    Route::put('/siguiente_ronda/{room_id}', 'JuegoController@nextRound');
    Route::post('/nuevo_juego', 'JuegoController@createNuevo');
    Route::delete('/close_table/{room_id}', 'JuegoController@closeTable');    
});

Route::group(['middleware' => 'api','prefix' => 'auth'], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});
