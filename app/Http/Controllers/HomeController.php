<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Mail;
use App\User;
use App\Evento;
use App\Espacio;
use App\Categoria;
use App\Mail\ConsultaAnfitrion;
use App\Mail\ConsultaUsuario;

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
                ->with('images', 'priceByCategory')
                ->where('status', true)
                ->orderBy('order')
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
                ->orderBy('order')
                ->paginate(30);
        }

        $categorias = Categoria::orderBy('id')->pluck('name', 'id');
        return view('search', array(
                'espacios' => $espacios->appends($querystringArray),
                'categorias' => $categorias
            )
        );
    }

    /**
     * @brief Funcion que renderiza a la vista del Espacio
     * @param $categoriaId
     * @param $name
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function espacio($categoriaId, $name)
    {
        $espacio = Espacio::where('staticname', $name)
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
                    ->select('id', 'price', 'daily', 'minhours')
                    ->where('espacio_id', $espacio->id)
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

    /**
     * @brief Funcion que redirecciona a la thank you page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function thankyou($id) {
        return view('thankyoupage', array("id" => $id));
    }

    /**
     * @brief Funcion que renderiza a la vista de consulta
     * @param $categoriaId
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function consulta($categoriaId, $id)
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

        return view('consulta', array(
                'espacio' => $espacio,
                'price' => $price,
                'categorias' => $categorias,
                'categoryId' => $categoriaId
            )
        );
    }

    /**
     * @brief Funcionque renderiza a la vista de reserva
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reserva($id)
    {
        $espacio = Espacio::find($id);
        return view('reserva', array('espacio' => $espacio));
    }

    /**
     * @brief Funcionque renderiza a la vista publicar
     * @param $espacioId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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

    /**
     * @fn send_reserva()
     * @brief Funcionque guarda la consulta en la base y a parte envía los emails
     * @param Request $request
     * @return Evento $evento
     */
    public function send_reserva(Request $request) {
        // Obtengo datos del organizador
        $cliente = User::find($request->clientId);
        // Obtengo datos del espacio
        $espacio = Espacio::where('id', $request->espacioId)
                    ->with('images')
                    ->first();
        // Obtengo datos del dueño
        $duenio = User::find($espacio->user_id);
        try {
            //Se crea el evento con los datos del request
            $evento = new Evento();
            $evento->nombre_evento = $request->title;
            $evento->titulo_cliente = $request->title;
            $evento->estilo_espacios_id = $request->category;
            $evento->invitados = $request->invitados;
            $evento->cliente_id = $request->clientId;
            $evento->user_id = $espacio->user_id;
            $evento->espacio_id = $request->espacioId;
            $evento->sub_total = $request->subTotal;
            $evento->total_horas = $request->totalHoras;
            $evento->descripcion_consulta = $request->mensaje;
            $evento->estado = 'consulta';
            $evento->telefono = $request->telefono;
            $evento->save();
            $days = [];
            foreach ($request->dias as $dia) {
                $days[] = array("evento_id" => $evento->id, "fecha" => $dia["date"], "tipo" => $dia["workingDay"]);
            }
            // Insert eventos dias
            DB::table('eventos_dias')->insert($days);

            // Insert en la tabla mensajes
            DB::table('mensajes')->insert([
                ["evento_id" => $evento->id, "user_id" => $request->clientId, "mensaje" => $request->mensaje]
            ]);

            // INICIO -- Datos de envio de email (Consulta al dueño)
            $emails = ['federico@wimet.co', 'alejandro@wimet.co','adrian@wimet.co'];
            // Email al anfitrion (Tienens una consulta)
            Mail::to($duenio->email)
                ->bcc($emails)
                ->queue(new ConsultaAnfitrion($evento, $espacio, $cliente));
            // Email al organizador (Consulta enviada)
            Mail::to($cliente->email)
                ->bcc($emails)
                ->queue(new ConsultaUsuario($evento, $espacio, $cliente));
            // FIN -- Datos de envio de email (Consulta al dueño)
            return $evento;
        }catch(\Exception $e){
            return response('Los campos no son correctos ' . $e->getMessage(), 400);
        }
    }

    /**
     * @fn checkEnvioRevicion()
     * @brief Funcion que controa el estatus de la publicacion
     * @param $espacio
     * @return bool
     */
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

    // Metodos a url estaticas
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

    /**
     * @brief Ruta callback de Api login de google
     * @param Request $request
     */
    public function callbackGoogle(Request $request) {
        dd($request->all());
    }
}