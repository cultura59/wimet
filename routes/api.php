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

Route::get('/sendmensaje', function() {

	$headers =  'MIME-Version: 1.0' . "\r\n"; 
	$headers .= 'From: Adrian Rojas <rojasadrian.e@gmail.com>' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 

	// the message
	$msg = "First line of text\nSecond line of text";

	// use wordwrap() if lines are longer than 70 characters
	$msg = wordwrap($msg,70);

	// send email
	mail("rojasadrian.e@gmail.com","My subject", $msg, $headers);
});

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
Route::get('/getpricea/{categoriaId}/espacio/{id}', 'EspacioController@getPrice');
Route::resource('categoria', 'CategoriaController');
Route::resource('tag', 'TagController');
Route::resource('servicio', 'ServicioController');
Route::resource('tipocliente', 'TipoClienteController');
Route::resource('consulta', 'ConsultaController');
Route::resource('image', 'ImageController');

Route::get('access', 'ApiHelpperController@access');
Route::get('accessibilities', 'ApiHelpperController@accessibilities');
Route::get('characteristics', 'ApiHelpperController@characteristics');
Route::get('estiloespacio', 'ApiHelpperController@estiloespacio');
Route::get('rules', 'ApiHelpperController@rules');
