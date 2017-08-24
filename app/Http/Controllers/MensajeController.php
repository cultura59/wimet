<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;
use App\Mensaje;
use App\Espacio;
use App\Evento;
use App\User;
use Mail;
use DB;
use App\Mail\MensajeAnfitrion;
use App\Mail\MensajeUsuario;
use App\Mail\SolicitudPresupuesto;

class MensajeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        try {
            $mensajes = DB::table('mensajes')
                            ->join('users', 'mensajes.user_id', '=', 'users.id')
                            ->select(
                                'users.firstname',
                                'users.imagesource',
                                'mensajes.mensaje',
                                'mensajes.created_at'
                            )
                            ->where('evento_id', $id)
                            ->orderBy('id', 'desc')
                            ->get();
            return $mensajes;
        }catch(\Exception $e){
            return response('Los campos no son correctos', 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // Obtengo datos del evento
            $evento = Evento::find($request->evento_id);
            // Obtengo datos del espacio
            $espacio = Espacio::where('id', $evento->espacio_id)->with('images')->first();
            // Obtengo los datos del dueño
            $user = User::find($evento->user_id);
            // Obtengo los datos del organizador
            $cliente = User::find($evento->cliente_id);
            // Obtengo los datos de la categoria
            $categoria = Categoria::find($evento->estilo_espacios_id);
            
            /* Datos de envio de email (Consulta al dueño */
            if($request->presupuesto) {
                Mail::to($user->email)->queue(new SolicitudPresupuesto($evento, $espacio, $user, $cliente, $categoria));
            }else {
                if ($request->user_id != $espacio->user_id) {
                    Mail::to($user->email)->queue(new MensajeAnfitrion($evento, $espacio, $user, $cliente, $categoria));
                } else {
                    Mail::to($cliente->email)->queue(new MensajeUsuario($evento, $espacio, $user, $cliente, $categoria));
                }
            }
            /* Datos de envio de email (Consulta al dueño */
            $mensaje = new Mensaje($request->all());
            $mensaje->save();
            return response($mensaje, 204); 
        }catch(\Exception $e){
            return response('Los campos no son correctos, '.$e->getMessage(), 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $mensajes = DB::table('mensajes')
                            ->select(
                                'users.firstname',
                                'users.imagesource',
                                'mensajes.mensaje',
                                'mensajes.created_at',
                                'mensajes.user_id',
                                'tipo_clientes.nombre'
                            )
                            ->join('users', 'mensajes.user_id', '=', 'users.id')
                            ->join('tipo_clientes', 'users.tipo_clientes_id', '=', 'tipo_clientes.id')
                            ->where('evento_id', $id)
                            ->orderBy('mensajes.id', 'desc')
                            ->get();
            return $mensajes;
        }catch(\Exception $e){
            return response('Los campos no son correctos, ' . $e->getMessage(), 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $mensajes = Mensaje::find($id);
            $mensajes->delete();
            return response('El mensaje fue borrado', 200);
        }catch(\Exception $e){
            return response('Los campos no son correctos', 400);
        }
    }
}
