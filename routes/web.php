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

Route::post('/nuevo_juego', 'JuegoController@createNuevo')->name('nuevo_juego');
Route::get('/juego/{id}', 'JuegoController@index')->name('juego_index');
Route::get('/nuevo_juego', 'JuegoController@indexCreate')->name('nuevo_juego_index');
Route::get('/unirse_juego', 'JuegoController@indexJoin')->name('unir_juego_index');
Route::put('/unirse_juego', 'JuegoController@joinRoom')->name('join_room');

Route::get('/', 'HomeController@index');
Route::middleware('admin')->get('/admin', 'AdminController@index');
Route::get('/admin/edit_user/{id}', 'AdminController@editUser')->name('edit_user');
Route::post('/admin/edit_user', 'AdminController@handleEditUser')->name('post_edit_user');
Route::delete('/admin/user/{id}', 'AdminController@deleteUser')->name('delete_user');
Auth::routes();
