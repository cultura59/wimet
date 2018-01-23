<?php
/**
 * Created by PhpStorm.
 * User: arojas
 * Date: 18/11/2017
 * Time: 6:09 PM
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MP;
use App\User;
use App\UserSenias;

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
        try {
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
            if($res['response']['status'] == 'authorized') {
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
                    ->queue(new ConsultaAnfitrion($duenio, $request['espacio'], $user));

                return $user;
            }else {
                return response($res['response'], 404);
            }
        } catch (\Exception $e) {
            return response('Hubo un error al realizar el pago, ' . $e->getMessage(), 500);
        }
    }
}