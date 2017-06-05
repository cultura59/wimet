<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\User;
use App\Evento;
use App\Espacio;
use App\Categoria;
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
     * Show the application eventos.
     *
     * @return \Illuminate\Http\Response
     */
    public function eventos()
    {
        return view('dashboard.eventos');
    }

	/**
     * Show the application evento.
     * @param $eventoId
     * @return \Illuminate\Http\Response
     */
    public function evento($userId, $eventoId)
    {
        return view('dashboard.evento', array(
            'eventoId' => $eventoId
        ));
    }

    /**
     * Show the application mensajes.
     * @param $eventoId
     * @return \Illuminate\Http\Response
     */
    public function mensajes($eventoId)
    {
        return view('dashboard.mensajes', array(
            'eventoId' => $eventoId
        ));
    }

	/**
     * Show the application nuevapropuesta.
     *
     * @return \Illuminate\Http\Response
     */
    public function nuevapropuesta($eventoId)
    {
        $evento = Evento::find($eventoId);
        $espacio = Espacio::find($evento->espacio_id);
        return view('dashboard.newpropuesta', array(
            'eventoId' => $eventoId,
            'securitydeposit' => $espacio->securitydeposit,
            'cancellationflexibility' => $espacio->cancellationflexibility
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