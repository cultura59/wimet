<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Evento;
use App\Espacio;
use DB;
use League\Event\Event;
use Mockery\Exception;

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = DB::table('eventos');
        $query->select(
            'eventos.id',
            'eventos.estilo_espacios_id',
            'eventos.espacio_id',
            'eventos.titulo_cliente',
            'eventos.reserva_desde',
            'eventos.reserva_hasta',
            'eventos.total_horas',
            'eventos.sub_total',
            'eventos.invitados',
            'eventos.notas',
            'eventos.estado',
            'espacios.name',
            'mensajes.created_at',
            'mensajes.mensaje'
        );
        $query->join('espacios', 'eventos.espacio_id', '=', 'espacios.id');
        $query->join('mensajes', function ($join) {
            $join->on('eventos.id', '=', 'mensajes.evento_id')
                ->orderBy('mensajes.id', 'DESC')
                ->limit(1);
        });
        // Chequeo si se manda el filtro de estados
        if($request->has('statusEvento')) {
            $query->where('eventos.estado', '=', $request->input('statusEvento'));
        }
        $query->orderBy('mensajes.created_at', 'desc')->groupBy('eventos.id');
        $mensajes = $query->paginate(20);
        return $mensajes;
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
        try {
            $evento = Evento::find($request->id);
            $evento->update($request->all());
            return $evento;
        }catch(\Exception $e){
            return response('Los campos no son correctos: ' . $e->getMessage(), 400);
        }
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
    public function getMensajes(Request $request, $id, $type) {
        // Se chequea si el que pide los mensajes es anfitrion u organizador
        if($type == 1) {
            $whereType = 'eventos.cliente_id';
        }else {
            $whereType = 'eventos.user_id';
        }
        if ($request->has('estado')) {
            //Query de mensajes
            $mensajes = DB::table('eventos')
                ->select(
                    'eventos.id',
                    'eventos.estado',
                    'mensajes.created_at',
                    'mensajes.mensaje',
                    'users.firstname',
                    'users.imagesource'
                )
                ->join('users', 'eventos.user_id', '=', 'users.id')
                ->join('mensajes', function ($join) {
                    $join->on('eventos.id', '=', 'mensajes.evento_id')
                        ->orderBy('mensajes.id', 'DESC')
                        ->limit(1);
                })
                ->where($whereType, $id)
                ->where('eventos.estado', $request->input('estado'))
                ->orderBy('mensajes.created_at', 'desc')
                ->get();
        }else {
            //Query de mensajes
            $mensajes = DB::table('eventos')
                ->select(
                    'eventos.id',
                    'eventos.estado',
                    'mensajes.created_at',
                    'mensajes.mensaje',
                    'users.firstname',
                    'users.imagesource'
                )
                ->join('users', 'eventos.user_id', '=', 'users.id')
                ->join('mensajes', function ($join) {
                    $join->on('eventos.id', '=', 'mensajes.evento_id')
                        ->orderBy('mensajes.id', 'DESC')
                        ->limit(1);
                })
                ->where($whereType, $id)
                ->orderBy('mensajes.created_at', 'desc')
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
