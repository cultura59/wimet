<?php
/**
 * Created by PhpStorm.
 * User: arojas
 * Date: 18/11/2017
 * Time: 6:09 PM
 */

namespace App\Http\Controllers;

use App\Propuesta;
use Illuminate\Http\Request;
use MP;
use DB;
use Mail;
use App\User;
use App\Espacio;
use App\UserSenias;
use App\Mail\SendSenia;

class MercadoPagoController extends Controller
{
    public function responseMP(Request $request)
    {
        $mp = new MP("APP_USR-8248736349517024-123008-d168bc42d44c9358b71e900e44e54b20__LA_LD__-291916384");

        $request = array(
            "uri" => "/oauth/token",
            "data" => array(
                "client_secret" => $mp->get_access_token(),
                "grant_type" => "authorization_code",
                "code" => "AUTHORIZATION_CODE",
                "redirect_uri" => "REDIRECT_URI"
            ),
            "headers" => array(
                "content-type" => "application/x-www-form-urlencoded"
            ),
            "authenticate" => false
        );

        dd($mp->post($request));
    }

    /**
     * @fn sendPayment()
     * @param Request $request
     * @return array|\Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function sendPayment(Request $request) {
        DB::begintransaction();
        try {
            //$mp = new MP("TEST-8248736349517024-123008-431710274c1eef4ee4331ae7b658cfcf__LA_LD__-291916384");
            $mp = new MP("APP_USR-8248736349517024-123008-d168bc42d44c9358b71e900e44e54b20__LA_LD__-291916384");
            $payment_data = array(
                "transaction_amount" => 1800,
                "token" => $request["token"],
                "description" => "Correspondiente a seña del espacio " . $request['espacio']["name"],
                "installments" => 1,
                "payment_method_id" => $request["paymentMethodId"],
                "payer" => array (
                    "email" => $request["email"],
                    "first_name" => $request["firstname"],
                    "last_name" => $request["lastname"]
                ),
                "capture" => false
            );
            $res = $mp->post("/v1/payments", $payment_data);
            switch ($res['response']['status']) {
                case 'authorized':
                    $senia = new UserSenias();
                    $senia->user_id = $request['user_id'];
                    $senia->paymentid = $res['response']['id'];
                    $senia->vencimiento = $request['vencimiento'];
                    $senia->save();
                    $user = User::with('senias')->where('id', $request['user_id'])->first();
                    $espacio = Espacio::find($request['espacio_id']);
                    $duenio = User::find($espacio->user_id);

                    // Habilito la consulta para 3 espacios
                    $user->descuentos = 3;
                    $user->save();

                    $emails = ['federico@wimet.co', 'alejandro@wimet.co','adrian@wimet.co'];
                    // Email al organizador (Datos del espacio)
                    Mail::to($user->email)
                        ->bcc($emails)
                        ->queue(new SendSenia($duenio, $espacio, $user));
                    DB::commit();
                    return $user;
                case 'in_process':
                    $senia = new UserSenias();
                    $senia->user_id = $request['user_id'];
                    $senia->paymentid = $res['response']['id'];
                    $senia->vencimiento = $request['vencimiento'];
                    $senia->save();
                    $user = User::with('senias')->where('id', $request['user_id'])->first();
                    $duenio = User::find($request['espacio']["user_id"]);

                    $emails = ['federico@wimet.co', 'alejandro@wimet.co','adrian@wimet.co'];
                    // Email al organizador (Datos del espacio)
                    Mail::to($user->email)
                        ->bcc($emails)
                        ->queue(new SendSenia($duenio, $request['espacio'], $user));
                    DB::commit();
                    return $user;
                case 'rejected':
                    DB::rollback();
                    return response('El pago fue rechazado. Su tarjeta fue rechazada, intente pagar nuevamente.', 404);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response('Hubo un error al realizar el pago, ' . $e, 500);
        }
    }

    /**
     * @fn sendData()
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function sendData(Request $request) {
        DB::begintransaction();
        try {
            $user = User::with('senias')->find($request['user_id']);
            $espacio = Espacio::find($request['espacio_id']);
            $duenio = User::find($espacio->user_id);
            $emails = ['federico@wimet.co', 'alejandro@wimet.co', 'adrian@wimet.co'];
            $user->descuentos = $user->descuentos - 1;
            $user->save();
            // Email al organizador (Datos del espacio)
            Mail::to($user->email)
                ->bcc($emails)
                ->queue(new SendSenia($duenio, $espacio, $user));
            DB::commit();
            return $user;
        }catch (\Exception $e) {
            DB::rollback();
            return response("No se pudo envíar los datos del espacio, vuelva a intentarlo", 500);
        }
    }

    /**
     * @fn callbackMP()
     * @param Request $request
     * @return array
     */
    public function callbackMP(Request $request) {
        $mp = new MP("TEST-8248736349517024-123008-431710274c1eef4ee4331ae7b658cfcf__LA_LD__-291916384");
        //$mp = new MP("APP_USR-8248736349517024-123008-d168bc42d44c9358b71e900e44e54b20__LA_LD__-291916384");

        $requestMP = array(
            "uri" => "/oauth/token",
            "data" => array(
                "client_secret" => $mp->get_access_token(),
                "grant_type" => "authorization_code",
                "code" => $request->code,
                "redirect_uri" => "https://wimet.co/callbackMP?userid=".$request->userid
            ),
            "headers" => array(
                "content-type" => "application/x-www-form-urlencoded"
            ),
            "authenticate" => false
        );

        $res = $mp->post($requestMP);

        // Actualizacion de token del usuario
        if($request->has('userid')) {
            $user = User::find($request->userid);
            $user->access_token = $res["response"]["access_token"];
            $user->public_key = $res["response"]["public_key"];
            $user->refresh_token = $res["response"]["refresh_token"];
            $user->save();
            return redirect('https://wimet.co/dashboard#/perfil');
        }
    }

    /**
     * @fn payPayment()
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function payPayment(Request $request) {
        DB::begintransaction();
        try {
            $duenio = User::find($request['espacio']['user_id']);
            $propuesta = Propuesta::find($request['propuestaid']);
            $pagos = $propuesta->with('pagos')->get();
            $comision = ($propuesta->sub_total * 15) / 100;

            if($duenio == null) {
                return response('Hubo un error al intentar cobrar el pago', 404);
            }

            // Calculo la comision de wimet en base a la seña
            if($pagos[0]['pdescripcion'] == 'senia') {
                $pagoWimet = $comision - $pagos[0]['ptotal'];
                if($pagoWimet < 0) {
                    $pagoWimet = 0;
                }
            }else {
                $pagoWimet = $comision;
            }

            $mp = new MP("TEST-8248736349517024-123008-431710274c1eef4ee4331ae7b658cfcf__LA_LD__-291916384");
            //$mp = new MP("APP_USR-8248736349517024-123008-d168bc42d44c9358b71e900e44e54b20__LA_LD__-291916384");
            $payment_data = array(
                "transaction_amount" => $propuesta->total,
                "token" => "TEST-8248736349517024-021610-f10018ca114f8fc738e2380a0d69e518__LB_LD__-291916384", //$duenio->access_token,
                "description" => "Correspondiente al pago por el espacio " . $request['espacio']["name"],
                "installments" => 1,
                "payer" => array (
                    "email" => $request["email"],
                    "first_name" => $request["firstname"],
                    "last_name" => $request["lastname"]
                ),
                "payment_method_id" => $request["paymentMethodId"],
                "application_fee" => $pagoWimet
            );
            return $mp->post("/v1/payments", $payment_data);
        } catch (\Exception $e) {
            DB::rollback();
            return response('Hubo un error al realizar el pago, ' . $e, 500);
        }
    }
}