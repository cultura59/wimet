<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Evento;
use App\Espacio;
use DB;

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Evento::orderBy('id', 'DESC')->paginate(20);
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
            $evento = new Evento($request->all());
            $evento->save();
            return $evento;
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
    public function show($id)
    {
        try {
            $evento = Evento::find($id);
            return $evento;
        }catch(\Exception $e){
            return response('Hubo un error al buscar el evento: ' . $e->getMessage(), 400);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getMensajes($id, $type) {
        if($type == 1) {
            $mensajes = DB::table('eventos')
                ->select(
                    'eventos.id',
                    'eventos.created_at',
                    'eventos.descripcion_consulta',
                    'users.firstname',
                    'users.imagesource'
                )
                ->join('users', 'eventos.user_id', '=', 'users.id')
                ->where('eventos.cliente_id', $id)
                ->orderBy('eventos.id', 'desc')
                ->get();
        } else {
            $mensajes = DB::table('eventos')
            ->select(
                'eventos.id',
                'eventos.created_at',
                'eventos.descripcion_consulta',
                'users.firstname',
                'users.imagesource'
            )
            ->join('users', 'eventos.cliente_id', '=', 'users.id')
            ->where('eventos.user_id', $id)
            ->orderBy('eventos.id', 'desc')
            ->get();
        }
        return $mensajes;
    }

    /**
     * Display the specified getResumen.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getResumen($id) {
        $evento = Evento::find($id);
        $espacio = Espacio::where('id', $evento->espacio_id)
                            ->with('user')
                            ->with('estilosEspacio')
                            ->with('images')
                            ->first();
        $datos = [
            'evento' => $evento,
            'espacio' => $espacio
        ];
        return $datos;
    }
}
