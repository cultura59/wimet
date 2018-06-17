<?php

namespace App\Http\Controllers;

use App\Evento;
use Illuminate\Http\Request;
use App\Propuesta;
use App\Mensaje;
use App\User;
use App\PropuestaServicios;
use App\PropuestaPagos;
use App\PropuestaDias;
use DB;

class PropuestaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $query = Propuesta::query();
            $query->with('pagos', 'espacio');
            // Se chequea por si se piden propuestas de un evento
            if($request->has('evento_id')) {
                $query->where('evento_id', '=', $request->evento_id);
            }
            // Se chequea si es anfitrion u organizador
            if($request->has('type')) {
                if($request->type == 2) {
                    $query->where('cliente_id', '=', $request->user_id);
                }else {
                    $query->where('user_id', '=', $request->user_id);
                }
            }
            // realiza la query final
            $propuestas = $query->get();
            return $propuestas;
        }catch(\Exception $e){
            return response('No se encontraron propuestas asociadas al evento, ' . $e->getMessage(), 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $propuesta = new Propuesta($request->all());
            $propuesta->estado = 'enviada';
            $propuesta->save();

            $evento = Evento::find($propuesta->evento_id);
            $evento->estado = "presupuesto";
            $evento->save();

            // Agrego los servicios a la propuesta
            foreach ($request->servicios as $servicio) {
                $nServicio = new PropuestaServicios($servicio);
                $nServicio->propuesta_id = $propuesta->id;
                $nServicio->save();
            }
            // Agrego los pagos a la propuesta
            foreach ($request->pagos as $pago) {
                $nPago = new PropuestaPagos($pago);
                $nPago->propuesta_id = $propuesta->id;
                $nPago->save();
            }
            // Agrego los pagos a la propuesta
            foreach ($request->dias as $dia) {
                $nPago = new PropuestaDias($dia);
                $nPago->propuesta_id = $propuesta->id;
                $nPago->save();
            }
            $mensaje = new Mensaje();
            $mensaje->user_id = 1; 
            $mensaje->evento_id = $propuesta->evento_id; 
            $mensaje->mensaje = "El dueño del espacio envio una propuesta para el evento.";
            $mensaje->save();

            /* Datos de envio de email (presupuesto al organizador)
            $datos = [
                'mensaje' => $request->mensaje,
                'propuesta' => $propuesta,
                'espacio' => $espacio,
                'imagenEspacio' => $espacio->images[0]->name,
                'usuario' => $user,
                'cliente' => $cliente
            ];
            Mail::send('emails.envio-presupuesto', $datos, function ($message) use ($cliente) {
                $message->from('info@wimet.co', 'Wimet');
                $message->to($cliente->email)
                    ->bcc('info@wimet.co')
                    ->subject('Tienes un nuevo mensaje sobre tu evento');
            });
            Datos de envio de email (presupuesto al organizador) */
            DB::commit();
            return response($propuesta, 204); 
        }catch(\Exception $e){
            DB::rollback();
            return response('Los campos no son correctos, '.$e->getMessage(), 400);
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
            $query = Propuesta::with('evento', 'dias', 'pagos', 'servicios', 'espacio');
            $query->where('id', '=', $id);
            return $query->first();
        }catch(\Exception $e){
            return response('No se encontró la propuesta asociadas al id: ' . $id . ', error: ' . $e->getMessage(), 400);
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
        DB::begintransaction();
        try {
            $propuesta = Propuesta::find($id);
            if(!$propuesta) {
                return response('No se encontro la propuesta buscada', 404);
            }
            $propuesta->update($request->all());
            DB::commit();
            return $propuesta;
        }catch (\Exception $e) {
            DB::rollback();
            return response('No se pudo modificar el prosupuesto', 500);
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
        try {
            $propuesta = Propuesta::find($id);
            $propuesta->delete();
            return response('La propuesta fue borrada', 200);
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
    public function getPropuestas($id) {
        try {
            $propuestas = Propuesta::select(
                                                'propuestas.id', 
                                                'propuestas.created_at', 
                                                'propuestas.reserva_desde',
                                                'espacios.name',
                                                'propuestas.evento_id',
                                                'propuestas.total',
                                                'propuestas.estado'
                                            )
                            ->join('espacios', 'propuestas.espacio_id', '=', 'espacios.id')
                            ->where('cliente_id', $id)->get();
            return $propuestas;
        }catch(\Exception $e){
            return response('No se encontran propuestas asociadas al usuario id: ' . $id, 400);
        }
    }

    /**
     * Rechazar propuesta.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rechazar($id)
    {
        try {
            $propuesta = Propuesta::find($id);
            $propuesta->estado = 'rechazada';
            return response('La propuesta fue borrada', 200);
        }catch(\Exception $e){
            return response('Los campos no son correctos', 400);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function custom(Request $request) {
        try {
            DB::begintransaction();
            $cliente = User::where("email", "=", $request->user["email"])->first();

            // Chequeo si existe el usuario
            if(empty($cliente)) {
                // Si no existe el usuario lo creo
                $cliente = new User();
                $cliente->firstname = $request->user["firstname"];
                $cliente->lastname = $request->user["lastname"];
                $cliente->email = $request->user["email"];
                $cliente->password = bcrypt($request->user["firstname"]);
                $cliente->imagesource = "https://res.cloudinary.com/wimet/image/upload/ilustraciones/wimet_ic_avatar_black_big.svg";
                $cliente->save();
            }

            // Se crea un nuevo evento para asociar la propuesta
            $evento = new Evento();
            $evento->nombre_evento = $request->evento["nombre"];
            $evento->titulo_cliente = $request->evento["nombre"];
            $evento->estilo_espacios_id = $request->categoriaSelected["id"];
            $evento->lead = "externo";
            $evento->invitados = $request->evento["invitados"];
            $evento->user_id = $request->duenio;
            $evento->cliente_id = $cliente->id;
            $evento->espacio_id = $request->espacioSelected["id"];
            $evento->sub_total = $request->total_servicios;
            $evento->descripcion_consulta = $request->evento["nombre"];
            $evento->estado = "presupuesto";
            $evento->save();

            // Se crea una nueva propuesta
            $propuesta = new Propuesta();
            $propuesta->evento_id = $evento->id;
            $propuesta->estilo_espacios_id = $evento->estilo_espacios_id;
            $propuesta->invitados = $evento->invitados;
            $propuesta->user_id = $evento->user_id;
            $propuesta->cliente_id = $evento->cliente_id;
            $propuesta->espacio_id = $evento->espacio_id;
            $propuesta->sub_total = $evento->sub_total;
            $propuesta->tu_pago = $evento->sub_total;
            $propuesta->comision = $request->fee;
            $propuesta->fee = $request->fee;
            $propuesta->total = $evento->sub_total + $evento->fee;
            $propuesta->condiciones = ($request->evento["condiciones"]) ? $request->evento["condiciones"] : "";
            $propuesta->estado = "enviada";
            $propuesta->save();

            // Agrego los servicios a la propuesta
            foreach ($request->servicios as $servicio) {
                $nServicio = new PropuestaServicios($servicio);
                $nServicio->propuesta_id = $propuesta->id;
                $nServicio->save();
            }
            // Agrego los pagos a la propuesta
            foreach ($request->pagos as $pago) {
                $nPago = new PropuestaPagos($pago);
                $nPago->propuesta_id = $propuesta->id;
                $nPago->save();
            }
            // Agrego los pagos a la propuesta
            foreach ($request->dias as $dia) {
                $nPago = new PropuestaDias();
                $nPago->fecha = $dia["date"];
                $nPago->tipo = $dia["workingDay"];
                $nPago->propuesta_id = $propuesta->id;
                $nPago->save();
            }
            DB::commit();
            return response("La propuesta fue creada", 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response("No se pudo crear la propuesta " . $e->getMessage(), 500);
        }
    }
}
