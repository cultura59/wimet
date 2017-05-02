<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\User;
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
     * Show the application reservas.
     *
     * @return \Illuminate\Http\Response
     */
    public function reservas()
    {
        $categorias = categoria::all();
        return view('dashboard.reservas', array(
            'categorias' => $categorias
        ));
    }

	/**
     * Show the application reserva.
     * @param $reservaId
     * @return \Illuminate\Http\Response
     */
    public function reserva($reservaId)
    {
        $categorias = categoria::all();
        return view('dashboard.reserva', array(
            'categorias' => $categorias
        ));
    }

	/**
     * Show the application solicitudes.
     *
     * @return \Illuminate\Http\Response
     */
    public function solicitudes()
    {
        $categorias = categoria::all();
        return view('dashboard.solicitudes', array(
            'categorias' => $categorias
        ));
    }

	/**
     * Show the application solicitud.
     *
     * @return \Illuminate\Http\Response
     */
    public function solicitud($solicitudId)
    {
        $categorias = categoria::all();
        return view('dashboard.solicitud', array(
            'categorias' => $categorias
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