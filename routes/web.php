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

// Compra productos
Route::get('/compraproductos/{id}', 'CompraproductoController@show');

// Compras
Route::get('/compras', 'CompraController@index');
Route::post('/compras', 'CompraController@store');
Route::delete('/compras/{id}', 'CompraController@delete');

// Empresas
Route::get('/empresas', 'EmpresaController@index');
Route::get('/empresas/{id}', 'EmpresaController@show');
Route::post('/empresas', 'EmpresaController@store');
Route::put('/empresas/{id}', 'EmpresaController@update');

// Inventarios
Route::get('/inventario', 'InventarioController@index');
Route::post('/inventario', 'InventarioController@store');

// Productos
Route::get('/productos', 'ProductoController@index');
Route::get('/productos/{id}', 'ProductoController@show');
Route::post('/productos', 'ProductoController@store');
Route::put('/productos/{id}', 'ProductoController@update');
Route::delete('/productos/{id}', 'ProductoController@delete');

// Proveedores
Route::get('/proveedores', 'ProveedoreController@index');
Route::get('/proveedores/{id}', 'ProveedoreController@show');
Route::post('/proveedores', 'ProveedoreController@store');
Route::put('/proveedores/{id}', 'ProveedoreController@update');

// Roles
Route::get('/roles', 'RoleController@index');

// Usuarios
Route::get('/usuarios', 'UserController@index');
Route::get('/usuarios/{id}', 'UserController@show');
Route::post('/usuarios', 'UserController@store');
Route::put('/usuarios/{id}', 'UserController@update');

// Ventas 
Route::get('/ventas', 'VentaController@index');
Route::get('/ventas/{id}', 'VentaController@show');
Route::post('/ventas', 'VentaController@store');

// Venta productos
Route::get('/ventaproductos/{id}', 'ProductoventaController@show');
