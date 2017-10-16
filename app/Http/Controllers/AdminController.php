<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Espacio;
use App\Evento;
use App\Mensaje;

class AdminController extends Controller
{
    public function dashboard() 
    {
    	return view('admin.dashboard');
    }

    public function mensajes()
    {
    	return view('admin.mensajes');
    }

    /**
     * @fn Funcion que retorna los datos del admin
     * @return \Illuminate\Contracts\Routing\ResponseFactory|string|\Symfony\Component\HttpFoundation\Response
     */
    public function admindash() {
        try {
            $eventos = Evento::select('eventos.id', 'eventos.titulo_cliente', 'espacios.name', 'eventos.created_at')
                ->join('espacios', 'eventos.espacio_id', '=', 'espacios.id')
                ->orderBy('eventos.id', 'DESC')->limit(10)->get();
            $mensajes = Mensaje::select('mensajes.id', 'users.firstname', 'mensajes.mensaje', 'mensajes.status', 'mensajes.created_at')
                ->join('users', 'mensajes.user_id', '=', 'users.id')
                ->orderBy('mensajes.id', 'DESC')->groupBy('mensajes.evento_id')->limit(5)->get();
            $res = array();
            $res['publicados'] = Espacio::where('step', '=', 6)->count();
            $res['pendientes'] = Espacio::where('step', '=', 5)->count();
            $res['tercerpaso'] = Espacio::where('step', '=', 4)->count();
            $res['segundopaso'] = Espacio::where('step', '=', 3)->count();
            $res['eventos'] = $eventos;
            $res['mensajes'] = $mensajes;
            return json_encode($res);
        }catch(\Exception $e){
            return response('Los campos no son correctos, ' . $e->getMessage(), 400);
        }
    }
}
