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
Route::get('/publicar', 'HomeController@publicar')->middleware('auth');
Route::get('/publicar/primer-paso', 'PublicaController@index')->middleware('auth');

Route::get('/publicar/primer-paso/espacio/{id}/categorias', 
			'PublicaController@primerPasoCategoria')
			->name('publica-categoria')->middleware('auth');
Route::get('/publicar/primer-paso/espacio/{id}/detalles', 
			'PublicaController@primerPasoDetalles')
			->name('publica-detalles')->middleware('auth');
Route::get('/publicar/primer-paso/espacio/{id}/invitados', 
			'PublicaController@primerPasoInvitados')
			->name('publica-invidatos')->middleware('auth');
Route::get('/publicar/primer-paso/espacio/{id}/maps', 
			'PublicaController@primerPasoMaps')
			->name('publica-maps')->middleware('auth');
Route::get('/publicar/segundo-paso/espacio/{id}/images', 
			'PublicaController@segundoPasoImages')
			->name('publica-images')->middleware('auth');
Route::get('/publicar/segundo-paso/espacio/{id}/amenities', 
			'PublicaController@segundoPasoAmenities')
			->name('publica-amenities')->middleware('auth');
Route::get('/publicar/segundo-paso/espacio/{id}/caracteristicas', 
			'PublicaController@segundoPasoCaracteristicas')
			->name('publica-caracteristicas')->middleware('auth');
Route::get('/publicar/segundo-paso/espacio/{id}/prices', 
			'PublicaController@segundoPasoPrice')
			->name('publica-prices')->middleware('auth');
Route::get('/publicar/segundo-paso/espacio/{id}/reglas', 
			'PublicaController@segundoPasoReglas')
			->name('publica-rules')->middleware('auth');

// Apis publica fron views
Route::post('saveespacio', 'EspacioController@saveEspacio');
Route::post('savecategories', 'EspacioController@saveCategory');
Route::post('saveaccess', 'EspacioController@saveAccess');
Route::post('saveinvitados', 'EspacioController@saveInvitados');
Route::post('saveadress', 'EspacioController@saveAdress');
Route::post('saveimages', 'EspacioController@saveImages');
Route::post('saveamenities', 'EspacioController@saveAmenities');
Route::post('savecaracteristicas', 'EspacioController@saveCaracteristicas');
Route::post('saveprice', 'EspacioController@savePrice');
Route::post('savereglas', 'EspacioController@saveRules');

Route::get('/redirect', 'SocialAuthController@redirect');
Route::get('/callback', 'SocialAuthController@callback');

Route::group(['prefix' => 'dashboard'], function() {
	Route::get('/user/{id}', 'DashboardController@index');	
	Route::get('/user/{id}/consultas', 'DashboardController@consultas');
	Route::get('/user/{id}/consulta/{consultaId}', 'DashboardController@consulta');
	Route::get('/user/{id}/reservas', 'DashboardController@reservas');	
	Route::get('/user/{id}/reserva/{reservaId}', 'DashboardController@reserva');	
	Route::get('/user/{id}/solicitudes', 'DashboardController@solicitudes');
	Route::get('/user/{id}/solicitud/{solicitudId}', 'DashboardController@solicitud');
	Route::get('/user/{id}/favoritos', 'DashboardController@favoritos');
});

Route::group(['prefix' => 'admin'], function ()
{
	Route::get('/dashboard', 'AdminController@dashboard');
	Route::get('/mensajes', 'AdminController@mensajes');
});