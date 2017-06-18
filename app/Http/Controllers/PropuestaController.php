<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Propuesta;
use App\Mensaje;

class PropuestaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $propuestas = Propuesta::where('evento_id', $id)->get();
            return $propuestas;
        }catch(\Exception $e){
            return response('No se encontraron propuestas asociadas al evento', 400);
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
            $mensaje = new Mensaje();
            $mensaje->user_id = 1; 
            $mensaje->evento_id = $propuesta->evento_id; 
            $mensaje->mensaje = "El dueño del espacio envio una propuesta para el evento.";
            $mensaje->save();
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
            $propuesta = Mensaje::find($id);
            $propuesta->delete();
            return response('La propuesta fue borrada', 200);
        }catch(\Exception $e){
            return response('Los campos no son correctos', 400);
        }
    }
}
