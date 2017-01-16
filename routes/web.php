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

Route::get('/redirect', 'SocialAuthController@redirect');
Route::get('/callback', 'SocialAuthController@callback');

Route::post('avatars', function() {
	$file = request()->file('file');
	$file->storeAs('avatars', "avatar.jpg");
	return back();
});

Route::group(['prefix' => 'admin'], function ()
{
	Route::get('/dashboard', 'AdminController@dashboard');
	Route::get('/mensajes', 'AdminController@mensajes');
});