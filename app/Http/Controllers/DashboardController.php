<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\User;
use App\Evento;
use App\Espacio;
use App\Categoria;
use App\Propuesta;
class DashboardController extends Controller
{
	/**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias = categoria::all();
        return view('dashboard.index', array(
            'categorias' => $categorias
        ));
    }

	/**
     * Show the application consultas.
     *
     * @return \Illuminate\Http\Response
     */
    public function consultas()
    {
        $categorias = categoria::all();
        return view('dashboard.consultas', array(
            'categorias' => $categorias
        ));
    }

    /**
     * Show the application consulta.
     * @param $consultaId
     * @return \Illuminate\Http\Response
     */
    public function consulta($consultaId)
    {
        $categorias = categoria::all();
        return view('dashboard.consulta', array(
            'categorias' => $categorias
        ));
    }

    /**
     * Show the application mensajes.
     * @param $userId
     * @return \Illuminate\Http\Response
     */
    public function mensajes()
    {
        return view('dashboard.mensajes');
    }

	/**
     * Show the application eventos.
     * @param $userId
     * @return \Illuminate\Http\Response
     */
    public function eventos($userId)
    {
        $countTotal = Evento::where('user_id', $userId)
                            ->count('id');
        $sumTotal = Evento::where('user_id', $userId)
                            ->sum('sub_total');
        
        $countConsultas = Evento::where('user_id', $userId)
                                    ->where('estado', 'consulta')
                                    ->count('id');
        $sumConsultas = Evento::where('user_id', $userId)
                                    ->where('estado', 'consulta')
                                    ->sum('sub_total');
        
        $countSeguimiento = Evento::where('user_id', $userId)
                                    ->where('estado', 'seguimiento')
                                    ->count('id');
        $sumSeguimiento = Evento::where('user_id', $userId)
                                    ->where('estado', 'seguimiento')
                                    ->sum('sub_total');

        $countVisita = Evento::where('user_id', $userId)
                                    ->where('estado', 'visita')
                                    ->count('id');
        $sumVisita = Evento::where('user_id', $userId)
                                    ->where('estado', 'visita')
                                    ->sum('sub_total');

        $countPresupuesto = Evento::where('user_id', $userId)
                                    ->where('estado', 'presupuesto')
                                    ->count('id');
        $sumPresupuesto = Evento::where('user_id', $userId)
                                    ->where('estado', 'presupuesto')
                                    ->sum('sub_total');

        $countReservado = Evento::where('user_id', $userId)
                                    ->where('estado', 'reservado')
                                    ->count('id');
        $sumReservado = Evento::where('user_id', $userId)
                                    ->where('estado', 'reservado')
                                    ->sum('sub_total');

        $countRealizado = Evento::where('user_id', $userId)
                                    ->where('estado', 'realizado')
                                    ->count('id');
        $sumRealizado = Evento::where('user_id', $userId)
                                    ->where('estado', 'realizado')
                                    ->sum('sub_total');

        $countPerdido = Evento::where('user_id', $userId)
                                    ->where('estado', 'perdido')
                                    ->count('id');
        $sumPerdido = Evento::where('user_id', $userId)
                                    ->where('estado', 'perdido')
                                    ->sum('sub_total');

        return view('dashboard.eventos', array(
            "countTotal" => $countTotal,
            "sumTotal" => $sumTotal,
            "countConsultas" => $countConsultas,
            "sumConsultas" => $sumConsultas,
            "countSeguimiento" => $countSeguimiento,
            "sumSeguimiento" => $sumSeguimiento,
            "countVisita" => $countVisita,
            "sumVisita" => $sumVisita,
            "countPresupuesto" => $countPresupuesto,
            "sumPresupuesto" => $sumPresupuesto,
            "countReservado" => $countReservado,
            "sumReservado" => $sumReservado,
            "countRealizado" => $countRealizado,
            "sumRealizado" => $sumRealizado,
            "countPerdido" => $countPerdido,
            "sumPerdido" => $sumPerdido
        ));
    }

	/**
     * Show the application evento.
     * @param $eventoId
     * @return \Illuminate\Http\Response
     */
    public function evento($userId, $eventoId)
    {
        $evento = Evento::find($eventoId);
        $espacio = Espacio::where('id', $evento->espacio_id)
                            ->with('user')
                            ->with('estilosEspacio')
                            ->with('images')
                            ->first();
        return view('dashboard.evento', array(
            'evento' => $evento,
            'espacio' => $espacio
        ));
    }

    /**
     * Show the application chats.
     * @param $eventoId
     * @return \Illuminate\Http\Response
     */
    public function chats($userId, $eventoId)
    {
        $evento = Evento::find($eventoId);
        $espacio = Espacio::where('id', $evento->espacio_id)
                            ->with('user')
                            ->with('estilosEspacio')
                            ->with('images')
                            ->first();
        return view('dashboard.chats', array(
            'evento' => $evento,
            'espacio' => $espacio
        ));
    }

	/**
     * Show the application nuevapropuesta.
     *
     * @return \Illuminate\Http\Response
     */
    public function nuevapropuesta($userId, $eventoId)
    {
        $evento = Evento::find($eventoId);
        $espacio = Espacio::find($evento->espacio_id);
        return view('dashboard.newpropuesta', array(
            'evento' => $evento,
            'espacio' => $espacio
        ));
    }

    public function propuesta($userId, $eventoId, $propuestaId)
    {
        $evento = Evento::find($eventoId);
        $espacio = Espacio::where('id', $evento->espacio_id)
                            ->with('user')
                            ->with('estilosEspacio')
                            ->with('images')
                            ->first();
        $propuesta = DB::table('propuestas')
                            ->select('propuestas.*', 'categorias.name as catname')
                            ->join('categorias', 'propuestas.estilo_espacios_id', '=', 'categorias.id')
                            ->where('propuestas.id', $propuestaId)
                            ->first();
        return view('dashboard.propuesta', array(
            'evento' => $evento,
            'espacio' => $espacio,
            'propuesta' => $propuesta,
            'userId' => $userId
        ));
    }

	/**
     * Show the application favoritos.
     *
     * @return \Illuminate\Http\Response
     */
    public function favoritos()
    {
        $categorias = categoria::all();
        return view('dashboard.index', array(
            'categorias' => $categorias
        ));
    }

    /**
     * Show the application mis espacios.
     *
     * @return \Illuminate\Http\Response
     */
    public function misespacios($id)
    {
        $espacios = Espacio::where('user_id', $id)
                    ->where('status', true)
                    ->with('categorias')
                    ->with('images')
                    ->get();

        $borradores = Espacio::where('user_id', $id)
                    ->where('status', false)
                    ->with('categorias')
                    ->with('images')
                    ->get();
        return view('dashboard.espacios', array(
            'espacios' => $espacios,
            'borradores' => $borradores
        ));
    }

    public function datos($id) {
        $user = User::find($id);
        return view('dashboard.datos', array('user' => $user));
    }
}