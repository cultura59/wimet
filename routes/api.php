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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::resource('espacio', 'EspacioController');
Route::get('/getpricea/{categoriaId}/espacio/{id}', 'EspacioController@getPrice');
Route::resource('categoria', 'CategoriaController');
Route::resource('tag', 'TagController');
Route::resource('servicio', 'ServicioController');
Route::resource('tipocliente', 'TipoClienteController');
Route::resource('consulta', 'ConsultaController');
Route::resource('image', 'ImageController');
