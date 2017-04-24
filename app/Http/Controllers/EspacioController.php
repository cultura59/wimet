<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Espacio;
use App\Image;
use App\Price;
use App\User;
use DB;

class EspacioController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $espacios = Espacio::with(
                'prices', 
                'categorias', 
                'servicios',
                'estilosEspacio',
                'rules',
                'images',
                'characteristics',
                'access'
            )->get();
        return $espacios;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $espacio = new Espacio();
        $espacio->user_id = $request->user_id;
        $espacio->name = $request->name;
        $espacio->description = $request->description;
        $espacio->quantyrooms = $request->quantyrooms;
        $espacio->quantybathrooms = $request->quantybathrooms;
        $espacio->floor = $request->floor;
        $espacio->surface = $request->surface;
        $espacio->seated = $request->seated;
        $espacio->quanty = $request->quanty;
        $espacio->adress = $request->adress;
        $espacio->type = $request->type;
        $espacio->city = $request->city;
        $espacio->state = $request->state;
        $espacio->country = $request->country;
        $espacio->long = $request->long;
        $espacio->lat = $request->lat;
        $espacio->status = false;
        $espacio->save();
        return $espacio;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $espacio = Espacio::where('id', $id)
                    ->with(
                        'prices', 
                        'categorias', 
                        'servicios',
                        'estilosEspacio',
                        'rules',
                        'images',
                        'characteristics',
                        'access'
                    )
                    ->first();
        return $espacio;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getEspacio($categoriaId, $id)
    {
        $espacio = DB::table('espacios')
                    ->join('categoria_espacio', 'espacios.id', '=', 'categoria_espacio.espacio_id')
                    ->join('prices', function($join) {
                        $join->on('espacios.id', '=', 'prices.espacio_id');
                        $join->on('categoria_espacio.categoria_id', '=', 'prices.categoria_id');
                    })
                    ->join('images', 'espacios.id', '=', 'images.espacio_id')
                    ->join('users', 'espacios.user_id', '=', 'users.id')
                    ->select('espacios.name', 'espacios.quanty', 'images.name as image', 'prices.price', 'users.imagesource')
                    ->where([
                        ['espacios.id', '=', $id],
                        ['categoria_espacio.categoria_id', '=', $categoriaId],
                    ])
                    ->get();
        return $espacio;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $espacio = Espacio::find($id);
        $espacio->delete();
        return $id;
    }

    /**
    * @fn saveEspacioWithoutData()
    * @brief Funcion que guarda un espacio desde la vista registracion espacio
    * @param Object $request
    * @return redirect to public-categoria
    */
    public function saveEspacioWithoutData(Request $request) {
        $espacio = new Espacio($request->all());
        $espacio->status = false;
        $espacio->save();
        $espacio->estilosEspacio()->sync($request->estilos);
        return \Redirect::route('publica-categoria', array('id' => $espacio->id));
    }

    /**
    * @fn saveEspacio()
    * @brief Funcion que guarda un espacio desde la vista registracion espacio
    * @param Object $request
    * @return redirect to public-categoria
    */
    public function saveEspacio(Request $request) {
        $espacio = Espacio::find($request->id);
        $espacio->name = $request->name;
        $espacio->description = $request->description;
        $espacio->save();
        return \Redirect::route('publica-steps', array(
                "espacioId" => $espacio->id,
                "step" => 3
            )
        );
    }

    /**
    * @fn saveCategory()
    * @brief Funcion que asocia categorias a un espacio
    * @param Object $request
    * @return redirect to public-detalles
    */
    public function saveCategory(Request $request) {
        $espacio = Espacio::find($request->id);
        if(!$request->categorias){
            $request->session()->flash('alert-danger', 'Debe seleccionar alguna actividad');
            return \Redirect::route('publica-categoria', array('id' => $espacio->id));
        }
        $espacio->categorias()->sync($request->categorias);
        $espacio->save();
        $espacio->prices()->delete();
        $espacio->save();
        foreach ($request->categorias as $key => $categoria) {
            $price = new Price;
            $price->espacio_id = $espacio->id;
            $price->categoria_id = $categoria;
            $price->price = 0;
            $price->minhours = 0;
            $price->status = true;
            $price->save();
        }
        return \Redirect::route('publica-detalles', array('id' => $request->id));
    }

    /**
    * @fn saveAccess()
    * @brief Funcion que asocia accesos a un espacio
    * @param Object $request
    * @return redirect to public-invidatos
    */
    public function saveAccess(Request $request) {
        $espacio = Espacio::find($request->id);
        if($request->quantyrooms) {
            $espacio->quantyrooms = $request->quantyrooms;
        }
        if($request->quantybathrooms) {
            $espacio->quantybathrooms = $request->quantybathrooms;
        }
        if($request->floor) {
            $espacio->floor = $request->floor;
        }
        if($request->surface) {
            $espacio->surface = $request->surface;
        }
        if($request->access) {
            $espacio->access()->sync($request->access);
        }
        $espacio->save();
        return \Redirect::route('publica-invidatos', array('id' => $request->id));
    }

    /**
    * @fn saveInvitados()
    * @brief Funcion que asocia cantidad invitados a un espacio
    * @param Object $request
    * @return redirect to public-maps
    */
    public function saveInvitados(Request $request) {
        $espacio = Espacio::find($request->id);
        if($request->quanty) {
            $espacio->quanty = $request->quanty;
        }
        if($request->foot) {
            $espacio->foot = $request->foot;
        }
        if($request->seated) {
            $espacio->seated = $request->seated;
        }
        $espacio->save();
        return \Redirect::route('publica-maps', array('id' => $espacio->id));
    }

    /**
    * @fn saveAdress()
    * @brief Funcion que asocia direccion a un espacio
    * @param Object $request
    * @return redirect to public-images
    */
    public function saveAdress(Request $request) {
        $espacio = Espacio::find($request->id);
        if($request->route && $request->street_number) {
            $espacio->adress = $request->route . " " . $request->street_number;
        }
        if($request->locality) {
            $espacio->state = $request->locality;
        }
        if($request->administrative_area_level_1) {
            $espacio->city = $request->administrative_area_level_1;
        }
        if($request->country) {
            $espacio->country = $request->country;
        }
        if($request->lat) {
            $espacio->lat = $request->lat;
        }
        if($request->long) {
            $espacio->long = $request->long;
        }
        $espacio->save();
        return \Redirect::route('publica-steps', array(
                "espacioId" => $espacio->id,
                "step" => 2
            )
        );
    }

    /**
    * @fn saveImages()
    * @brief Funcion que asocia imagenes a un espacio
    * @param Object $request
    * @return redirect to public-amenities
    */
    public function saveImages(Request $request) {
        if($request->hasFile('imagenes')) {
            // upload the image //
            $imagesEspacio = $request->file('imagenes');
            $destination_fotoprincipales = 'fotosespacios/';

            foreach ($imagesEspacio as $key => $img) 
            {
                $filename_imagesEspacio = str_random(8).'_'.$img->getClientOriginalName();
                $img->move($destination_fotoprincipales, $filename_imagesEspacio);
                $image = new Image;
                $image->name = $destination_fotoprincipales . $filename_imagesEspacio;
                $image->espacio_id = $request->espacio_id;
                $image->save();
            }
        }
        return \Redirect::route('publica-caracteristicas', array('id' => $request->espacio_id));
    }

    /**
    * @fn saveAmenities()
    * @brief Funcion que asocia amenities a un espacio
    * @param Object $request
    * @return redirect to public-caracteristicas
    */
    public function saveAmenities(Request $request) {
        if($request->servicios) {
            $espacio = Espacio::find($request->id);
            $espacio->servicios()->sync($request->servicios);
            $espacio->save();
        }
        return \Redirect::route('publica-titulo', array('id' => $request->id));
    }

    /**
    * @fn saveImages()
    * @brief Funcion que asocia imagenes a un espacio
    * @param Object $request
    * @return redirect to public-caracteristicas
    */
    public function saveCaracteristicas(Request $request) {
        if($request->characteristics) {
            $espacio = Espacio::find($request->id);
            $espacio->characteristics()->sync($request->characteristics);
            $espacio->save();
        }
        return \Redirect::route('publica-amenities', array('id' => $request->id));
    }

    /**
    * @fn saveRules()
    * @brief Funcion que asocia las reglas a un espacio
    * @param Object $request
    * @return redirect to public-caracteristicas
    */
    public function saveRules(Request $request) {
        if($request->rules) {
            $espacio = Espacio::find($request->id);
            $espacio->rules()->sync($request->rules);
            $espacio->save();
        }
        return \Redirect::route('publica-prices', array('id' => $request->id));
    }

    /**
    * @fn savePrice()
    * @brief Funcion que asocia precios a un espacio
    * @param Object $request
    * @return redirect to public-caracteristicas
    */
    public function savePrice(Request $request) {
        $price = Price::find($request->priceId);
        if($request->espacio_id) {
            $price->espacio_id = $request->espacio_id;
        }
        if($request->categoria_id) {
            $price->categoria_id = $request->categoria_id;
        }
        if($request->price) {
            $price->price = $request->price;
        }
        if($request->minhours) {
            $price->minhours = $request->minhours;
        }
        $price->status = $request->status;
        $price->save();
        $request->session()->flash('alert-success', 'El precio fue guardado :)');
        return \Redirect::back();
    }

    /**
    * @fn saveCancelacion()
    * @brief Funcion que asocia cantidad invitados a un espacio
    * @param Object $request
    * @return redirect to public-maps
    */
    public function saveCancelacion(Request $request) {
        $espacio = Espacio::find($request->id);
        if($request->securitydeposit) {
            $espacio->securitydeposit = $request->securitydeposit;
        }
        if($request->cancellationflexibility) {
            $espacio->cancellationflexibility = $request->cancellationflexibility;
        }
        $espacio->save();
        return \Redirect::route('publica-steps', array(
                "espacioId" => $espacio->id,
                "step" => 4
            )
        );
    }

    /**
    * @fn saveWishlist()
    * @brief Funcion que asocia un espacio a un usuaio
    * @param Object $request
    * @return true o false
    */
    public function saveWishlist(Request $request) {
        $user = User::find($request->clientId);
        if($user->id == null){
            return false;
        }
        $user->wishlist()->sync($request->espacio_id);
        return true;
    }
}
