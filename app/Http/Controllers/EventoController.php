<?php

namespace App\Http\Controllers;

use App\Mensaje;
use App\User;
use Illuminate\Http\Request;
use App\Evento;
use App\EventosDias;
use App\Espacio;
use DB;

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
            'eventos.*',
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
        $user = User::find($id);
        // Se chequea si el que pide los mensajes es anfitrion u organizador
        if($type == 1) {
            $whereType = 'eventos.cliente_id';
        }else {
            $whereType = 'eventos.user_id';
        }
        //Query de eventos
        $queryEventos = Evento::query();
        $queryEventos->select('id');
        if ($request->has('estado')) {
            $queryEventos->where('eventos.estado', $request->input('estado'));
        }

        // Chequeo si el usuario es admin ignoro los filtros
        if(!$user->isAdmin) {
            $queryEventos->where($whereType, $id);
        }
        $eventosIds = $queryEventos->get();

        //Query de mensajes
        $queryMensjes = DB::table('mensajes');
        $queryMensjes->select('mensajes.*', 'users.imagesource', 'users.firstname', 'espacios.name');
        $queryMensjes->join('users', 'mensajes.user_id', '=', 'users.id');
        $queryMensjes->join('eventos', 'mensajes.evento_id', '=', 'eventos.id');
        $queryMensjes->join('espacios', 'eventos.espacio_id', '=', 'espacios.id');
        $queryMensjes->whereIn('evento_id', $eventosIds);
        $queryMensjes->orderBy('mensajes.id', 'desc');
        $mensajes = $queryMensjes->distinct('evento_id')->paginate(15);
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

    public function getDias($id) {
        $dias = EventosDias::where('evento_id', '=', $id)->get();
        return $dias;
    }
}
