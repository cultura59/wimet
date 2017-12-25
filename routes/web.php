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

// Ruta principal HOME
Route::get('/', 'HomeController@index');

Auth::routes();

// Ruta logout
Route::get('/logout', function() {
	Auth::logout();
	return back();
});

// Rutas a pantallas principales y estaticas
Route::get('/home', 'HomeController@index');
Route::get('/search', 'HomeController@search');
Route::get('/categoria/{categoriaId}/espacio/{name}', 'HomeController@espacio')->name('homespacio');
Route::get('/consulta/{categoriaId}/espacio/{id}', 'HomeController@consulta');
Route::get('/espacio/{id}/evento', 'HomeController@evento')->name('evento');
Route::get('/thankyou/{id}', 'HomeController@thankyou');
Route::get('/callbackgoogle', 'HomeController@callbackGoogle');
Route::get('/nosotros', 'HomeController@nosotros');
Route::get('/equipo', 'HomeController@equipo');
Route::get('/prensa', 'HomeController@prensa');
Route::get('/publica', 'HomeController@publica');
Route::get('/publica/thankyou/{id}/espacio/{espacioId}', 'PublicaController@thankyou');
Route::get('/enviaraprobacion/{id}', 'PublicaController@enviarAprobacion');
Route::get('/confirmaccount/{id}', 'UserController@confirmAccount');

// Primer pantala de publica tu espacio
Route::get('/publicar/espacio/{espacioId}', 'HomeController@publicar')->name('publica-steps');
Route::get('/publica/espacio', 'PublicaController@index');

// Agrupador de las pantallas de publica tu espacio
Route::group(['prefix' => 'publicar'], function() {
	Route::get('/user/{id}/primer-paso', 'PublicaController@index');
	//Primer paso con sus acciones
	Route::group(['prefix' => 'primer-paso'], function() {
		Route::get('/espacio/{id}/categorias', 
					'PublicaController@primerPasoCategoria')
					->name('publica-categoria');
		Route::get('/espacio/{id}/detalles', 
					'PublicaController@primerPasoDetalles')
					->name('publica-detalles');
		Route::get('/espacio/{id}/invitados', 
					'PublicaController@primerPasoInvitados')
					->name('publica-invidatos');
		Route::get('/espacio/{id}/maps', 
					'PublicaController@primerPasoMaps')
					->name('publica-maps');
	});
	//Segundo paso con sus acciones
	Route::group(['prefix' => 'segundo-paso'], function () {
		Route::get('/espacio/{id}/images', 
					'PublicaController@segundoPasoImages')
					->name('publica-images');
		Route::get('/espacio/{id}/caracteristicas', 
					'PublicaController@segundoPasoCaracteristicas')
					->name('publica-caracteristicas');
		Route::get('/espacio/{id}/amenities', 
					'PublicaController@segundoPasoAmenities')
					->name('publica-amenities');
		Route::get('/espacio/{id}/titulo', 
					'PublicaController@segundoPasoTitulo')
					->name('publica-titulo');
	});
	//Tercer paso con sus acciones
	Route::group(['prefix' => 'tercer-paso'], function () {
		Route::get('/espacio/{id}/reglas', 
					'PublicaController@tercerPasoReglas')
					->name('publica-rules');
		Route::get('/espacio/{id}/prices', 
					'PublicaController@tercerPasoPrice')
					->name('publica-prices');
		Route::get('/espacio/{id}/disponibilidad', 
					'PublicaController@tercerPasoDisponibilidad')
					->name('publica-disponibilidad');
		Route::get('/espacio/{id}/cancelacion', 
					'PublicaController@tercerPasoCancelaciones')
					->name('publica-cancelacion');
	});
});

// Apis publica fron views
Route::post('saveEspaciowithoutdata', 'EspacioController@saveEspacioWithoutData');
Route::post('saveespacio', 'EspacioController@saveEspacio');
Route::post('savecategories', 'EspacioController@saveCategory');
Route::post('saveaccess', 'EspacioController@saveAccess');
Route::post('saveinvitados', 'EspacioController@saveInvitados');
Route::post('saveadress', 'EspacioController@saveAdress');
Route::post('saveamenities', 'EspacioController@saveAmenities');
Route::post('savecaracteristicas', 'EspacioController@saveCaracteristicas');
Route::post('saveprice', 'EspacioController@savePrice');
Route::post('savereglas', 'EspacioController@saveRules');
Route::post('wishlist', 'EspacioController@saveWishlist');
Route::post('savecancelacion', 'EspacioController@saveCancelacion');

// Agrupador de pantallas del Dashboard
Route::group(['prefix' => 'dashboard'], function() {
    Route::get('/', 'DashboardController@index');
	//Route::get('/user/{id}', 'DashboardController@index');
	Route::get('/user/{id}/mensajes', 'DashboardController@mensajes');
	Route::get('/user/{id}/consultas', 'DashboardController@consultas');
	Route::get('/user/{id}/consulta/{consultaId}', 'DashboardController@consulta');
	Route::get('/user/{id}/eventos', 'DashboardController@eventos');
	Route::get('/user/{id}/propuestas', 'DashboardController@propuestas')->name('propuestas');
	Route::get('/user/{id}/evento/{eventoId}', 'DashboardController@evento');	
	Route::get('/user/{id}/evento/{eventoId}/chats', 'DashboardController@chats');	
	Route::get('/user/{id}/evento/{eventoId}/nuevapropuesta', 'DashboardController@nuevapropuesta');	
	Route::get('/user/{id}/evento/{eventoId}/propuesta/{propuestaId}', 'DashboardController@propuesta');	
	Route::get('/user/{id}/confirmar/{propuestaId}', 'DashboardController@confirm');
	Route::get('/user/{id}/respuesta/{propuestaId}', 'DashboardController@propuestaSuccess');
	Route::get('/user/{id}/favoritos', 'DashboardController@favoritos');
	Route::get('/user/{id}/misespacios', 'DashboardController@misespacios')->name('misespacios');
	Route::get('/user/{id}/datos', 'DashboardController@datos');
});

Route::group(['prefix' => 'admin'], function (){
    Route::get('/', 'AdminController@dashboard');
    Route::get('getinfo', 'AdminController@admindash');
});