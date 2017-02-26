<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'HomeController@index');

Auth::routes();
Route::get('/logout', function() {
	Auth::logout();
	return back();
});

Route::get('/home', 'HomeController@index');
Route::get('/search', 'HomeController@search');
Route::get('/categoria/{categoriaId}/espacio/{id}', 'HomeController@espacio')->name('homespacio');
Route::get('/espacio/{id}/reserva', 'HomeController@reserva')->name('reserva');
Route::get('/publicar', 'HomeController@publicar');
Route::get('/publicar/primer-paso', 'PublicaController@index');

Route::get('/publicar/primer-paso/espacio/{id}/categorias', 
			'PublicaController@primerPasoCategoria')
			->name('publica-categoria');
Route::get('/publicar/primer-paso/espacio/{id}/detalles', 
			'PublicaController@primerPasoDetalles')
			->name('publica-detalles');
Route::get('/publicar/primer-paso/espacio/{id}/invitados', 
			'PublicaController@primerPasoInvitados')
			->name('publica-invidatos');
Route::get('/publicar/primer-paso/espacio/{id}/maps', 
			'PublicaController@primerPasoMaps')
			->name('publica-maps');
Route::get('/publicar/segundo-paso/espacio/{id}/images', 
			'PublicaController@segundoPasoImages')
			->name('publica-images');
Route::get('/publicar/segundo-paso/espacio/{id}/amenities', 
			'PublicaController@segundoPasoAmenities')
			->name('publica-amenities');
Route::get('/publicar/segundo-paso/espacio/{id}/caracteristicas', 
			'PublicaController@segundoPasoCaracteristicas')
			->name('publica-caracteristicas');

// Apis publica fron views
Route::post('saveespacio', 'EspacioController@saveEspacio');
Route::post('savecategories', 'EspacioController@saveCategory');
Route::post('saveaccess', 'EspacioController@saveAccess');
Route::post('saveinvitados', 'EspacioController@saveInvitados');
Route::post('saveadress', 'EspacioController@saveAdress');
Route::post('saveimages', 'EspacioController@saveImages');
Route::post('saveamenities', 'EspacioController@saveAmenities');
Route::post('savecaracteristicas', 'EspacioController@saveCaracteristicas');

Route::get('/redirect', 'SocialAuthController@redirect');
Route::get('/callback', 'SocialAuthController@callback');


Route::group(['prefix' => 'admin'], function ()
{
	Route::get('/dashboard', 'AdminController@dashboard');
	Route::get('/mensajes', 'AdminController@mensajes');
});