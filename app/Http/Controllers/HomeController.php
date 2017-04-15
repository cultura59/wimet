<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use DB;
use App\User;
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
    public function search(Request $request) {   
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
                                ->with('images')
                                ->paginate(10);
        }else {
            $espacios = Espacio::select('id', 'name', 'quanty')
                                ->whereHas('categorias', 
                                    function($query) {
                                    $query->where('id', \Request::input('categoria'));
                                })
                                ->with('images')
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
                'categorias' => $categorias,
                'categoryId' => $categoriaId
            )
        );
    }

    public function reserva($id)
    {
        $espacio = Espacio::find($id);
        return view('reserva', array('espacio' => $espacio));
    }

    public function publicar($id, $espacioId)
    {
        return view('publicar', array(
                "espacioId" => $espacioId,
                "step" => $id
            )
        );
    }

    public function send_reserva(Request $request) {
        $cliente = User::find($request->clientId);
        //dd($cliente->firstname);
        $espacio = Espacio::find($request->espacioId);
        $data = [
            "usuario" => $cliente,
            "espacio" => $espacio,
            "reserva" => $request
        ];
        
        Mail::send(["text"=>"email"], $data, function($message){
            $message->to("rojasadrian.e@gmail.com", "Adrian Rojas")
                    ->subject("Tienes una nueva consulta por tu espacio");

            $message->from("adrian@wimet.co", "Consultas Wimet");
        });
    }
}
