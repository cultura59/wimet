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

Route::get('/usersession', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::resource('espacio', 'EspacioController');
Route::get('/getespacio/categoria/{categoriaId}/espacio/{id}', 'EspacioController@getEspacio')->middleware('throttle:200,1');
Route::resource('categoria', 'CategoriaController');
Route::resource('tag', 'TagController');
Route::resource('servicio', 'ServicioController');
Route::resource('caracteristica', 'CharacteristicsController');
Route::resource('tipocliente', 'TipoClienteController');
Route::resource('consulta', 'ConsultaController');
Route::resource('image', 'ImageController');
Route::resource('user', 'UserController');
Route::resource('evento', 'EventoController');
Route::resource('mensaje', 'MensajeController');
Route::resource('propuesta', 'PropuestaController');
Route::resource('disponibilidad', 'DisponibilidadController');
Route::resource('price', 'PriceController');

Route::get('access', 'ApiHelpperController@access');
Route::get('accessibilities', 'ApiHelpperController@accessibilities');
Route::get('characteristics', 'ApiHelpperController@characteristics');
Route::get('estiloespacio', 'ApiHelpperController@estiloespacio');
Route::get('rules', 'ApiHelpperController@rules');

Route::get('mpresponse', 'MercadoPagoController@responseMP');

Route::post('saveportada/{id}', 'EspacioController@savePortada');
Route::delete('deleteportada/{id}', 'EspacioController@destroyPortada');
Route::post('customlogin', 'UserController@customLogin');
Route::post('user/foto/{id}', 'UserController@changeAvatar');
Route::post('sendreserva', 'HomeController@send_reserva');
Route::get('geteventos/{id}', 'UserController@getEventos');
Route::get('changepassword/{id}/password/{contra}', 'UserController@cambiarContraseniaRedes');
Route::get('mensajes/{id}/type/{type}', 'EventoController@getMensajes');
Route::get('evento/resumen/{id}', 'EventoController@getResumen');
Route::get('listpropuestas/{id}', 'PropuestaController@getPropuestas');
Route::get('propuesta/{id}/rechazada', 'PropuestaController@rechazar');
Route::get('mensaje/{id}/send', 'MensajeController@sendEmailConsulta');
Route::get('searchespacios', 'EspacioController@searchEspacios');
Route::get('eventosdias/{id}', 'EventoController@getDias');
Route::put('userupdate/{id}', 'UserController@updateUserConfirm');
Route::put('updatepass/{id}', 'UserController@cambiarContrasenia')->name('updatepass');
Route::get('emailexist/{email}', 'UserController@emailExist');
