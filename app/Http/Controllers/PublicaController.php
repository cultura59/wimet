<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EstiloEspacio;
use App\Categoria;
use App\Espacio;
use App\Access;
use App\Price;
use App\Servicio;
use App\Characteristics;
use App\Rules;

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

    /**
    * @fn segundoPasoCaracteristicas
    * @brief Funcion que retorna la vista donde se agregan los caracteristicas del espacio
    * @return render image caracteristicas
    */
    public function segundoPasoCaracteristicas($id) {
        $characteristics = Characteristics::all();
        return View('publicar.caracteristicas',
            array(
                'id' => $id,
                'characteristics' => $characteristics
            )
        );
    }

    /**
    * @fn segundoPasoAmenities
    * @brief Funcion que retorna la vista donde se agregan los amenities del espacio
    * @return render image amenities
    */
    public function segundoPasoAmenities($id) {
        $amenities = Servicio::all();
        return View('publicar.amenities',
            array(
                'id' => $id,
                'amenities' => $amenities
            )
        );
    }

    /**
    * @fn segundoPasoAmenities
    * @brief Funcion que retorna la vista donde se agregan los amenities del espacio
    * @return render image amenities
    */
    public function segundoPasoTitulo($id) {
        $espacio = Espacio::find($id);
        return View('publicar.title', array('espacio' => $espacio));
    }

    /**
    * @fn tercerPasoPrice
    * @brief Funcion que retorna la vista donde se agregan los caracteristicas del espacio
    * @return render image caracteristicas
    */
    public function tercerPasoPrice($id) {
        $espacio = Espacio::with('prices')
                    ->where('id', $id)
                    ->first();
        $prices = Price::select('prices.*', 'categorias.name')
                    ->join('categorias', 'categorias.id', '=', 'prices.categoria_id')
                    ->where('prices.espacio_id', $id)
                    ->get();

        return View('publicar.prices',
            array(
                'espacio' => $espacio,
                'prices' => $prices
            )
        );
    }

    /**
    * @fn tercerPasoReglas()
    * @brief Funcion que retorna la vista donde se agregan las relgas del espacio
    * @return render image reglas
    */
    public function tercerPasoReglas($id) {
        $rules = Rules::all();
        return view('publicar.reglas', 
            array(
                'id' => $id,
                'reglas' => $rules
            )
        );
    }
}
