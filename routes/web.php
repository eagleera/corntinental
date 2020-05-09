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

Route::middleware('admin')->get('/', function () {
    return view('welcome');
});
Route::middleware('admin')->get('/admin', 'AdminController@index');
Route::get('/admin/edit_user/{id}', 'AdminController@editUser')->name('edit_user');
Route::post('/admin/edit_user', 'AdminController@handleEditUser')->name('post_edit_user');
Route::delete('/admin/user/{id}', 'AdminController@deleteUser')->name('delete_user');
Auth::routes();
