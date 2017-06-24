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
use App\User;
use Auth;

class PublicaController extends Controller
{
	/**
	* @fn index()
	* @brief Funcion que retorna la vista principal de publicar espacio
	* @return render index page
	*/
    public function index(Request $request, $id) {
        $user = User::find($id);
        $espaciosUser = $user->espacios()->where('status', false)->get();
        if($espaciosUser->count() >= 1) {
            $request->session()->flash('alert-danger', 'Ya posee espacios en borrador, debe finalizar los mismos.');
            return \Redirect::route('misespacios', array('id' => $id));
        }
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
        $espacio = Espacio::with('access')->find($id);
    	$access = Access::all();
    	return view('publicar.accesos', 
    		array(
    			'espacio' => $espacio,
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
        $espacio = Espacio::find($id);
    	return view('publicar.invitados', 
    		array('espacio' => $espacio)
		);
    }

	/**
	* @fn primerPasoMaps()
	* @brief Funcion que retorna la vista donde se agrega la dirección del espacio
	* @return render maps page
	*/
    public function primerPasoMaps($id) {
    	$espacio = Espacio::find($id);
        if($espacio->adress != null) {
            $street = explode(" ", $espacio->adress);
            $number = array_pop($street);
            $street = implode(" ", $street);
            return view('publicar.maps', 
        		array(
                    'street_number' => $street,
                    'route' => $number,
                    'espacio' => $espacio
                )
    		);
        }else {
            return view('publicar.maps', 
                array(
                    'espacio' => $espacio
                )
            );
        }
    }

    /**
    * @fn segundoPasoImages
    * @brief Funcion que retorna la vista donde se agregan las imagenes del espacio
    * @return render image page
    */
    public function segundoPasoImages($id) {
        $espacio = Espacio::with('images')->find($id);
        return view('publicar.images', 
            array(
                'espacio' => $espacio
            )
        );
    }

    /**
    * @fn segundoPasoCaracteristicas
    * @brief Funcion que retorna la vista donde se agregan los caracteristicas del espacio
    * @return render image caracteristicas
    */
    public function segundoPasoCaracteristicas($id) {
        $espacio = Espacio::with('characteristics')->find($id);
        $characteristics = Characteristics::all();
        return View('publicar.caracteristicas',
            array(
                'espacio' => $espacio,
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
        $espacio = Espacio::with('servicios')->find($id);
        $amenities = Servicio::all();
        return View('publicar.amenities',
            array(
                'espacio' => $espacio,
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
        return View('publicar.title', array('espacioId' => $id));
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
    * @fn tercerPasoDisponibilidad
    * @brief Funcion que retorna la vista donde se agregan los caracteristicas del espacio
    * @return render image caracteristicas
    */
    public function tercerPasoDisponibilidad($id) {
        $espacio = Espacio::find($id);

        return View('publicar.disponibilidad',
            array(
                'espacio' => $espacio
            )
        );
    }

    /**
    * @fn tercerPasoReglas()
    * @brief Funcion que retorna la vista donde se agregan las relgas del espacio
    * @return render image reglas
    */
    public function tercerPasoReglas($id) {
        $espacio = Espacio::with('rules')->find($id);
        $rules = Rules::all();
        return view('publicar.reglas', 
            array(
                'espacio' => $espacio,
                'reglas' => $rules
            )
        );
    }

    /**
    * @fn tercerPasoCancelaciones()
    * @brief Funcion que retorna la vista donde se agregan las politicas de cancelacion del espacio
    * @return render image reglas
    */
    public function tercerPasoCancelaciones($id) {
        $espacio = Espacio::with('rules')->find($id);
        return view('publicar.cancelacion', 
            array(
                'espacio' => $espacio
            )
        );
    }
}
