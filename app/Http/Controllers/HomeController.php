<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Espacio;
use App\Categoria;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
    */
    public function __construct()
    {
        $this->middleware('auth')->only('reserva');
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

    /**
     * @fn search()
     * @brief Funcion que retorna la vista del resultados
     * @param Long categoria
     * @param String ubicacion
     * @param Long quanty
     * @param Double price
     * @return \Illuminate\Http\Response 
     */
    public function search(Request $request)
    {   
        if($request->has('price') && $request->has('quanty'))
        {
            $espacios = Espacio::select('id', 'name', 'quanty')
                                ->where('quanty', '>=', \Request::input('quanty'))
                                ->whereHas('categorias', 
                                    function($query) {
                                    $query->where('id', \Request::input('categoria'));
                                })
                                ->whereHas('priceByCategory', 
                                    function($query) {
                                    $query->where('price', '>=', \Request::input('price'));
                                })
                                ->paginate(10);
        }else {
            $espacios = Espacio::select('id', 'name', 'quanty')
                                ->whereHas('categorias', 
                                    function($query) {
                                    $query->where('id', \Request::input('categoria'));
                                })
                                ->paginate(10);
        }

        $categorias = Categoria::orderBy('id')->pluck('name', 'id');
        return view('search', array(
                'espacios' => $espacios,
                'categorias' => $categorias
            )
        );
    }

    public function espacio($categoriaId, $id)
    {
        $espacio = Espacio::where('id', $id)
                    ->with(
                        'prices', 
                        'images', 
                        'categorias', 
                        'servicios',
                        'estilosEspacio',
                        'rules',
                        'characteristics',
                        'access'
                    )
                    ->first();

        $categorias = categoria::orderBy('id')->pluck('name', 'id');

        $price = DB::table('prices')
                    ->select('id', 'price', 'minhours')
                    ->where('espacio_id', $id)
                    ->where('categoria_id', $categoriaId)
                    ->first();

        return view('espacio', array(
                'espacio' => $espacio,
                'price' => $price,
                'categorias' => $categorias
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
