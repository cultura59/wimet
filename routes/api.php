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

Route::get('images/{filename}', function ($filename)
{
    $path = storage_path() . '/' . $filename;

    if(!File::exists($path)) abort(404);

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});

Route::resource('espacio', 'EspacioController');
Route::get('/getespacio/categoria/{categoriaId}/espacio/{id}', 'EspacioController@getEspacio');
Route::resource('categoria', 'CategoriaController');
Route::resource('tag', 'TagController');
Route::resource('servicio', 'ServicioController');
Route::resource('tipocliente', 'TipoClienteController');
Route::resource('consulta', 'ConsultaController');
Route::resource('image', 'ImageController');
Route::resource('user', 'UserController');
Route::resource('evento', 'EventoController');
Route::resource('mensaje', 'MensajeController');
Route::resource('propuesta', 'PropuestaController');

Route::get('access', 'ApiHelpperController@access');
Route::get('accessibilities', 'ApiHelpperController@accessibilities');
Route::get('characteristics', 'ApiHelpperController@characteristics');
Route::get('estiloespacio', 'ApiHelpperController@estiloespacio');
Route::get('rules', 'ApiHelpperController@rules');

Route::post('sendreserva', 'HomeController@send_reserva');
Route::get('geteventos/{id}', 'UserController@getEventos');