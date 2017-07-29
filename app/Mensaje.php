<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
	protected $fillable = ['evento_id', 'user_id', 'mensaje'];

	private $keyHuspot = "153f6544-3085-41e5-98d0-80a3d435d496";
	private $endpoint = "https://api.hubapi.com/";

	/*
	* @method serviceCreateContact()
	* @brief Funcion que crea un nuevo contacto en Hubspot
	* @request Array Usuer
	* @response json Status y datos del user hubspot
	*/
	function serviceCreateContact($arr) {
		try {
			$post_json = json_encode($arr);
			$url = $this->endpoint . "contacts/v1/contact?hapikey=" . $this->keyHuspot;
	        $response = $this->serviceSendPost($post_json, $url);
	        return $response;
	    }catch(\Exception $e){
            return response('No se pudo crear el usuario en hubspot, ' . $e->getMessage(), 500);
        }
	}

	/*
	* @method serviceSendEmail()
	* @brief Funcion que envia emails a los clientes en base a un template
	* @request Int $templateId, Array $message, Array $customProperties
	*/
	function serviceSendEmail($templateId, $email, $customProperties) {
		try {
			$arrProperties = [];
			//Recorro las propiedades custom para armar la plantilla del email
			foreach ($customProperties as $key => $customProperty) {
				$arrProperties->push(
					array(
	                    'name' => $customProperty["name"],
	                    'value' => $customProperty["value"]
	                )
				);
			}

			//Array de to, from email
            $arrMessage = array(
                'to' => $email,
                'from' => "adrian@wimet.co"
            );

			//Array para enviar en el POST Curl
			$arr = array(
				'emailId' => $templateId,
				'message' => $arrMessage,
	            'customProperties' => $arrProperties
	        );

			$post_json = json_encode($arr);
			$url = $this->endpoint . "email/public/v1/singleEmail/send?hapikey=" . $this->keyHuspot;
	        $response = $this->serviceSendPost($post_json, $url);
			return $response;
		}catch(\Exception $e) {
			return response('No se pudo envíar el email via hubspot, ' . $e->getMessage(), 500);
		}
	}

	/*
	* @method serviceSendPost()
	* @brief Funcion que ejecuta una peticion curl
	* @request Json $jsonData, Strring $url
	* @response Array {status: code, data: array}
	*/
	function serviceSendPost($jsonData, $url) {
		$ch = @curl_init();
        @curl_setopt($ch, CURLOPT_POST, true);
        @curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        @curl_setopt($ch, CURLOPT_URL, $url);
        @curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        @curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = @curl_exec($ch);
        $status_code = @curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_errors = curl_error($ch);
        @curl_close($ch);
        echo "curl Errors: " . $curl_errors;
        echo "\nStatus code: " . $status_code;
        echo "\nResponse: " . $response;
        $arrResponse = [
        	"status" => $curl_errors,
        	"data" => $response
		];
        return $arrResponse;
	}
}
