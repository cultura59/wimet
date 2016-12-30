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

Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/search', 'HomeController@search');
Route::get('/espacio/{id}', 'HomeController@espacio');
Route::get('/espacio/{id}/reserva', 'HomeController@reserva')->name('reserva');

Route::get('/redirect', 'SocialAuthController@redirect');
Route::get('/callback', 'SocialAuthController@callback');


Route::group(['prefix' => 'admin'], function ()
{
	Route::get('/dashboard', 'AdminController@dashboard');
	Route::get('/mensajes', 'AdminController@mensajes');
});