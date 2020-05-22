<?php

use Illuminate\Support\Facades\Route;

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

// Route::post('/nuevo_juego', 'JuegoController@createNuevo')->name('nuevo_juego');
// Route::get('/juego/{id}', 'JuegoController@index')->name('juego_index');
// Route::get('/nuevo_juego', 'JuegoController@indexCreate')->name('nuevo_juego_index');
// Route::get('/unirse_juego', 'JuegoController@indexJoin')->name('unir_juego_index');
// Route::put('/unirse_juego', 'JuegoController@joinRoom')->name('join_room');

Route::view('/', 'app');
Route::view('/{any}', 'app');
Route::view('/{any}/{other}', 'app');