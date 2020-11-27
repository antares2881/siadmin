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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Categorias
Route::get('/categorias', 'CategoriaController@index');
Route::get('/categorias/{id}', 'CategoriaController@show');
Route::put('/categorias/{id}', 'CategoriaController@update');
Route::post('/categorias', 'CategoriaController@store');

// Clientes
Route::get('/clientes', 'ClienteController@index');
Route::get('/clientes/{id}', 'ClienteController@show');
Route::post('/clientes', 'ClienteController@store');
Route::put('/clientes/{id}', 'ClienteController@update');

// Inventarios
Route::get('/inventario', 'InventarioController@index');
Route::post('/inventario', 'InventarioController@store');

// Productos
Route::get('/productos', 'ProductoController@index');
Route::get('/productos/{id}', 'ProductoController@show');
Route::post('/productos', 'ProductoController@store');
Route::put('/productos/{id}', 'ProductoController@update');
Route::delete('/productos/{id}', 'ProductoController@delete');
