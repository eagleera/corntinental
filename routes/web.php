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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/sueldo_semanal', function () {
    return view('sueldo_semanal');
});
Route::post('/sueldo_semanal', ['as' => 'Practica11.sueldo_semanal', "uses" => "Practica11Controller@calcularSueldo"]);
Route::get('/febrero14', function () {
    return view('febrero14');
});
Route::post('/febrero14', ['as' => 'Practica11.febrero14', "uses" => "Practica11Controller@calcularRegalo"]);
Route::get('/descuento', function () {
    return view('descuento');
});
Route::post('/descuento', ['as' => 'Practica11.descuento', "uses" => "Practica11Controller@calcularDescuento"]);
Route::get('/becas', function () {
    return view('becas');
});
Route::post('/becas', ['as' => 'Practica11.becas', "uses" => "Practica11Controller@calcularBeca"]);