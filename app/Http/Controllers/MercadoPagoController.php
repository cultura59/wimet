<?php
/**
 * Created by PhpStorm.
 * User: arojas
 * Date: 18/11/2017
 * Time: 6:09 PM
 */

namespace App\Http\Controllers;

use App\UserSenias;
use Illuminate\Http\Request;
use App\User;
use MP;

class MercadoPagoController extends Controller
{
    public function responseMP(Request $request)
    {
        $mp = new MP("TEST-6273864499490098-112209-7476f9ba56d020f90a5a9ae647dd9fc5__LD_LA__-51885178");

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
        DB::beginTransaction();
        //try {
            $mp = new MP("TEST-8248736349517024-123008-431710274c1eef4ee4331ae7b658cfcf__LA_LD__-291916384");
            $payment_data = array(
                "transaction_amount" => 1800,
                "token" => $request["token"],
                "description" => "Seña por alquiler de espacio",
                "installments" => 1,
                "payment_method_id" => $request["paymentMethodId"],
                "payer" => array (
                    "email" => $request["email"],
                    "first_name" => $request["first_name"],
                    "last_name" => $request["last_name"]
                ),
                "capture" => false
            );
            $resMP = $mp->post("/v1/payments", $payment_data);
            return $resMP;
            // Chequeo si la respuesta de MP fue exitosa
            if($resMP['response']['status'] == 'autorizado') {
                $senia = new UserSenias();
                $senia->user_id = $request['user_id'];
                $senia->paymentid = $resMP['response']['id'];
                $senia->vencimiento = $request['vencimiento'];
                $senia->save();
                DB::commit();
                // Retorno el usuario con las senias
                $user = User::with('senias')
                            ->where('id', '=', $request['user_id'])
                            ->first();
                return $user;
            }else {
                return response('Su seña fue rechazada por la tarjeta', 404);
            }
        /*} catch (\Exception $e) {
            DB::rollback();
            return response('Hubo un error al realizar el pago, ' . $e, 500);
        }*/
    }
}