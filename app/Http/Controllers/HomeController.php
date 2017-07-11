<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use DB;
use App\User;
use App\Evento;
use App\Espacio;
use App\Mensaje;
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
        $querystringArray = \Request::only(['ubicacion','categoria','price','quanty']);
        $quanties = explode("-", \Request::input('quanty'));
        if(\Request::input('ubicacion') == "") {
            $espacios = Espacio::select('id', 'name', 'description', 'long', 'lat')
                ->with('images')
                ->whereBetween('quanty', [$quanties[0], $quanties[1]])
                ->whereHas('categorias', 
                    function($query) {
                        $query->where('id', \Request::input('categoria'));
                    }
                )
                ->whereHas('priceByCategory', 
                    function($query) {
                        $precios = explode("-", \Request::input('price'));
                        $query->whereBetween('price', [$precios[0], $precios[1]]);
                    }
                )
                ->where('status', true)
                ->paginate(30);
        } else {
            $espacios = Espacio::select('id', 'name', 'description', 'long', 'lat')
                ->with('images')
                ->whereBetween('quanty', [$quanties[0], $quanties[1]])
                ->whereHas('categorias', 
                    function($query) {
                        $query->where('id', \Request::input('categoria'));
                    }
                )
                ->whereHas('priceByCategory', 
                    function($query) {
                        $precios = explode("-", \Request::input('price'));
                        $query->whereBetween('price', [$precios[0], $precios[1]]);
                    }
                )
                ->where('status', true)
                ->where('city', \Request::input('ubicacion'))
                ->paginate(30);
        }

        $categorias = Categoria::orderBy('id')->pluck('name', 'id');
        return view('search', array(
                'espacios' => $espacios->appends($querystringArray),
                'categorias' => $categorias
            )
        );
    }

    public function espacio($categoriaId, $id)
    {
        $espacio = Espacio::where('id', $id)
                    ->with(
                        'user', 
                        'prices', 
                        'categorias', 
                        'servicios',
                        'estilosEspacio',
                        'rules',
                        'characteristics',
                        'access',
                        'disponibilidad'
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

    public function publicar($espacioId)
    {
        $espacio = Espacio::with('access')
                    ->with('rules')
                    ->with('prices')
                    ->find($espacioId);

        return view('publicar', array(
                "espacioId" => $espacioId,
                "step" => $espacio->step,
                "enviarValidacion" => $this->checkEnvioRevicion($espacio)
            )
        );
    }

    public function send_reserva(Request $request) {
        $cliente = User::find($request->clientId);
        $espacio = Espacio::find($request->espacioId);
        $data = [
            "usuario" => $cliente,
            "espacio" => $espacio,
            "reserva" => $request
        ];
        try {
            $evento = new Evento();
            $evento->titulo_cliente = $request->title;
            $evento->estilo_espacios_id = $request->category;
            $evento->invitados = $request->invitados;
            $evento->cliente_id = $request->clientId;
            $evento->user_id = $espacio->user_id;
            $evento->reserva_desde = $request->reserva_desde;
            $evento->reserva_hasta = $request->reserva_hasta;
            $evento->espacio_id = $request->espacioId;
            $evento->sub_total = $request->subTotal;
            $evento->total_horas = $request->totalHoras;
            $evento->descripcion_consulta = $request->mensaje;
            $evento->estado = 'consulta';
            $evento->save();

            DB::table('mensajes')->insert([
                ["evento_id" => $evento->id, "user_id" => $request->clientId, "mensaje" => $request->mensaje]
            ]);

            Mail::send(["text"=>"email"], $data, function($message){
                $message->to("rojasadrian.e@gmail.com", "Adrian Rojas")
                        ->subject("Tienes una nueva consulta por tu espacio");

                $message->from("adrian@wimet.co", "Consultas Wimet");
            });

            return $evento;
        }catch(\Exception $e){
            return response('Los campos no son correctos' . $e->getMessage(), 400);
        }
    }

    public function checkEnvioRevicion($espacio) {
        if($espacio->surface < 1) {
            return false;
        }

        if($espacio->foot < 1) {
            return false;
        }

        if($espacio->seated < 1) {
            return false;
        }

        if($espacio->access()->count() < 1) {
            return false;
        }

        if($espacio->rules()->count() < 1) {
            return false;
        }
        
        if($espacio->prices()->count() < 1) {
            return false;
        }
        return true;
    }



    public function nosotros()
    {
        return view('staticwebs.nosotros');
    }
    public function equipo()
    {
        return view('staticwebs.equipo');
    }
    public function prensa()
    {
        return view('staticwebs.prensa');
    }
    public function publica()
    {
        return view('staticwebs.publica');
    }
}

