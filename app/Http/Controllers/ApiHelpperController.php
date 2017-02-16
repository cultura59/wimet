<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Accessibilities;
use App\Characteristics;
use App\EstiloEspacio;
use App\Access;
use App\Rules;

class ApiHelpperController extends Controller
{
    /**
     * @fn access()
     * @brief Funcion que retorna los access al espacio
     * @return \Illuminate\Http\Response
     */
    public function access()
    {
        return Access::all();
    }

	/**
	 * @fn accessibilities()
     * @brief Funcion que retorna las accesibilidades al espacio
     * @return \Illuminate\Http\Response
     */
    public function accessibilities()
    {
    	return Accessibilities::all();
    }

    /**
     * @fn aharacteristics()
     * @frief Funcion que retorna las caracteristicas del espacio
     * @return \Illuminate\Http\Response
     */
    public function characteristics()
    {
    	return Characteristics::all();
    }

    /**
     * @fn estiloespacio()
     * @frief Funcion que retorna los estilos del espacio
     * @return \Illuminate\Http\Response
     */
    public function estiloespacio()
    {
    	return EstiloEspacio::all();
    }

    /**
     * @fn rules()
     * @frief Funcion que retorna las reglas que puede tener el espacio
     * @return \Illuminate\Http\Response
     */
    public function rules()
    {
    	return Rules::all();
    }
}
