<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;

class MailController extends Controller
{
    public function basic_email() {
    	$data = ["name"=>"Adrian Rojas"];
    	
    	Mail::send(["text"=>"email"], $data, function($message){
    		$message->to("federico@wimet.co", "Adrian Wimet")->subject("Tienes una nueva consulta por tu espacio");
    		$message->from("adrian@wimet.co", "Consultas Wimet");
	    });
    }

    public function html_email() {
    	$data = ["name"=>"Adrian Rojas"];
    	
    	Mail::send(["text"=>"email"], $data, function($message){
    		$message->to("adrian@wimet.co", "Adrian Wimet")->subject("Tienes una nueva consulta de tu espacio");
    		$message->from("rojasadrian.e@gmail.com", "Adrian Rojas");
	    });
    }
}
