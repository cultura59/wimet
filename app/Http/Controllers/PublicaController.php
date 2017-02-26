<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EstiloEspacio;
use App\Categoria;
use App\Espacio;
use App\Access;

class PublicaController extends Controller
{
	/**
	* @fn index()
	* @brief Funcion que retorna la vista principal de publicar espacio
	* @return render index page
	*/
    public function index() {
    	$estilos = EstiloEspacio::pluck('nombre', 'id');
    	return view('publicar.index', 
    		array(
    			'estilos' => $estilos
    		)
		);
    }

	/**
	* @fn primerPasoCategoria()
	* @brief Funcion que retorna la vista donde se agregan las categorias al espacio
	* @return render categorias page
	*/
    public function primerPasoCategoria($id) {
        $espacio = Espacio::with('categorias')->find($id);
    	$categorias = Categoria::with('subCategory')->get();
    	return view('publicar.categorias', 
    		array(
    			'espacio' => $espacio,
    			'categorias' => $categorias
    		)
		);
    }

	/**
	* @fn primerPasoDetalles()
	* @brief Funcion que retorna la vista donde se agregan los detalles al espacio
	* @return render detalles page
	*/
    public function primerPasoDetalles($id) {
    	$access = Access::all();
    	return view('publicar.accesos', 
    		array(
    			'id' => $id,
    			'access' => $access
    		)
		);
    }

	/**
	* @fn primerPasoInvitados()
	* @brief Funcion que retorna la vista donde se agregan los detalles al espacio
	* @return render invitados page
	*/
    public function primerPasoInvitados($id) {
    	return view('publicar.invitados', 
    		array('id' => $id)
		);
    }

	/**
	* @fn primerPasoMaps()
	* @brief Funcion que retorna la vista donde se agrega la dirección del espacio
	* @return render maps page
	*/
    public function primerPasoMaps($id) {
    	return view('publicar.maps', 
    		array('id' => $id)
		);
    }

    /**
    * @fn segundoPasoImages
    * @brief Funcion que retorna la vista donde se agregan las imagenes del espacio
    * @return render image page
    */
    public function segundoPasoImages($id) {
        return view('publicar.images', 
            array('id' => $id)
        );
    }
}
