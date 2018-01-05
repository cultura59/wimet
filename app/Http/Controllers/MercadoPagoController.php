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
        try {
            return $request->all();
            $mp = new MP("TEST-8248736349517024-122213-0a87e93a32890c78b05090e7cee77fcc__LD_LA__-291916384");
            $payment_data = array(
                "transaction_amount" => 1500,
                "token" => $request["token"],
                "description" => "Title of what you are paying for",
                "installments" => 1,
                "payment_method_id" => $request["paymentMethodId"],
                "payer" => array (
                    "email" => $request["email"]
                ),
                "capture" => false
            );
        }
        /*} catch (\Exception $e) {
            DB::rollback();
            return response('Hubo un error al realizar el pago, ' . $e, 500);
        }*/
    }
}