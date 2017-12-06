<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Propuesta;
use App\Espacio;
use App\Mensaje;
use App\User;

class PropuestaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $propuestas = Propuesta::where('evento_id', $request->eventoId)->get();
            return $propuestas;
        }catch(\Exception $e){
            return response('No se encontraron propuestas asociadas al evento, ' . $e->getMessage(), 400);
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
            $propuesta = new Propuesta($request->all());
            $propuesta->estado = 'enviada';
            $propuesta->save();
            
            $espacio = Espacio::where('id', $propuesta->espacio_id)->with('images')->first();
            $user = User::find($propuesta->user_id);
            $cliente = User::find($propuesta->cliente_id);

            $mensaje = new Mensaje();
            $mensaje->user_id = 1; 
            $mensaje->evento_id = $propuesta->evento_id; 
            $mensaje->mensaje = "El dueño del espacio envio una propuesta para el evento.";
            $mensaje->save();

            /* Datos de envio de email (presupuesto al organizador)
            $datos = [
                'mensaje' => $request->mensaje,
                'propuesta' => $propuesta,
                'espacio' => $espacio,
                'imagenEspacio' => $espacio->images[0]->name,
                'usuario' => $user,
                'cliente' => $cliente
            ];
            Mail::send('emails.envio-presupuesto', $datos, function ($message) use ($cliente) {
                $message->from('info@wimet.co', 'Wimet');
                $message->to($cliente->email)
                    ->bcc('info@wimet.co')
                    ->subject('Tienes un nuevo mensaje sobre tu evento');
            });
            Datos de envio de email (presupuesto al organizador) */
            
            return response($propuesta, 204); 
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
            $propuestas = Propuesta::where('evento_id', $id)->get();
            return $propuestas;
        }catch(\Exception $e){
            return response('No se encontran propuestas asociadas al evento id: ' . $id, 400);
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
            $propuesta = Propuesta::find($id);
            $propuesta->delete();
            return response('La propuesta fue borrada', 200);
        }catch(\Exception $e){
            return response('Los campos no son correctos', 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getPropuestas($id) {
        try {
            $propuestas = Propuesta::select(
                                                'propuestas.id', 
                                                'propuestas.created_at', 
                                                'propuestas.reserva_desde',
                                                'espacios.name',
                                                'propuestas.evento_id',
                                                'propuestas.total',
                                                'propuestas.estado'
                                            )
                            ->join('espacios', 'propuestas.espacio_id', '=', 'espacios.id')
                            ->where('cliente_id', $id)->get();
            return $propuestas;
        }catch(\Exception $e){
            return response('No se encontran propuestas asociadas al usuario id: ' . $id, 400);
        }
    }

    /**
     * Rechazar propuesta.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rechazar($id)
    {
        try {
            $propuesta = Propuesta::find($id);
            $propuesta->estado = 'rechazada';
            return response('La propuesta fue borrada', 200);
        }catch(\Exception $e){
            return response('Los campos no son correctos', 400);
        }
    }
}
