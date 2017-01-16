<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Espacio;
use App\categoria;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
    */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias = categoria::all();
        return view('home', array(
            'categorias' => $categorias
        ));
    }

    public function search()
    {
        $espacios = Espacio::paginate(10);
        $categorias = categoria::orderBy('id')->pluck('name', 'id');
        return view('search', array(
                'espacios' => $espacios,
                'categorias' => $categorias
            )
        );
    }

    public function espacio($categoriaId, $id)
    {
        $espacio = Espacio::where('id', $id)
                    ->with('prices', 'categorias', 'servicios', 'user')
                    ->first();

        $price = DB::table('prices')
                    ->select('id', 'price', 'minhours')
                    ->where('espacio_id', $id)
                    ->where('categoria_id', $categoriaId)
                    ->first();

        return view('espacio', array(
                'espacio' => $espacio,
                'price' => $price
            )
        );
    }

    public function reserva($id)
    {
        $espacio = Espacio::find($id);
        return view('reserva', array('espacio' => $espacio));
    }

    public function publicar()
    {
        return view('publicar');
    }
}
