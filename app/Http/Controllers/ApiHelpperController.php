<?php

namespace App\Http\Controllers;

use App\Espacio;
use Illuminate\Http\Request;
use App\Accessibilities;
use App\Characteristics;
use App\EstiloEspacio;
use App\Access;
use App\Rules;
use DB;

class ApiHelpperController extends Controller
{
    /**
     * @fn access()
     * @brief Funcion que retorna los access al espacio
     * @return \Illuminate\Http\Response
     */
    public function access()
    {
        return Access::select('id', 'nombre', 'icon')->get();
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

    public function repareDataBase() {
        DB::beginTransaction();
        try {
            $espacios = Espacio::with('images', 'prices')->get();
            $ordenEspacio = 1;
            foreach ($espacios as $espacio) {
                echo "Procesando espacio: " . $espacio->name . "<br>";
                $images = $espacio->images()->get();
                $prices = $espacio->prices()->get();

                $ordenImg = 1;
                foreach ($images as $image) {
                    echo "Procesando imagen: " . $image->name . "<br>";
                    if (strpos($image->name, "http://res.cloudinary.com/wimet") == false) {
                        $image->name = "http://res.cloudinary.com/wimet/image/upload/" . $image->name;
                    }
                    $image->imgorder = $ordenImg;
                    $image->save();
                    $ordenImg++;
                }

                echo "Cambio de foto de portada" . "<br>";
                if($images->count() > 0) {
                    $espacio->portada = $images[0]->name;
                }else {
                    echo "El espacio " . $espacio->name . " no posee imagenes<br>";
                }

                echo "Procesando precios categorias <br>";
                foreach ($prices as $price) {
                    $price->cantidad_personas = $espacio->quanty;
                    $price->save();
                }
                echo "Cambio del nombre del espacio a: ". str_slug($espacio->name) . " <br>";
                $espacio->staticname = str_slug($espacio->name);
                echo "Cambio del orden del espacio a: ". $ordenEspacio . " <br>";
                $espacio->order = $ordenEspacio;
                $espacio->save();
                echo "Fin del proceso de " . $espacio->name . "<br><br>";
                $ordenEspacio++;
            }
            DB::commit();
            echo "<strong>Fin del arreglo de la base de datos</strong>";
        }catch (\Exception $e) {
            DB::rollBack();
            echo "Error: " . $e->getMessage();
        }
    }
}
