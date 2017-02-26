<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Espacio;
use App\Image;

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
    public function update(Request $request, $id)
    {
        //
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

    public function saveEspacio(Request $request) {
        $espacio = new Espacio($request->all());
        $espacio->save();
        return \Redirect::route('publica-categoria', array('id' => $espacio->id));
    }

    public function saveCategory(Request $request) {
        $espacio = Espacio::find($request->id);

        //dd($request->categorias);
        $espacio->categorias()->sync($request->categorias);
        $espacio->save();
        return \Redirect::route('publica-detalles', array('id' => $request->id));
    }


    public function saveAccess(Request $request) {
        $espacio = Espacio::find($request->id);
        $espacio->quantyrooms = $request->quantyrooms;
        $espacio->quantybathrooms = $request->quantybathrooms;
        $espacio->floor = $request->floor;
        $espacio->surface = $request->surface;
        $espacio->access()->sync($request->access);
        $espacio->save();
        return \Redirect::route('publica-invidatos', array('id' => $request->id));
    }

    public function saveInvitados(Request $request) {
        $espacio = Espacio::find($request->id);
        $espacio->quanty = $request->quanty;
        $espacio->foot = $request->foot;
        $espacio->seated = $request->seated;
        $espacio->save();
        return \Redirect::route('publica-maps', array('id' => $espacio->id));
    }

    public function saveAdress(Request $request) {
        $espacio = Espacio::find($request->id);
        $espacio->adress = $request->route . " " . $request->street_number;
        $espacio->state = $request->locality;
        $espacio->city = $request->administrative_area_level_1;
        $espacio->country = $request->country;
        $espacio->lat = $request->lat;
        $espacio->long = $request->long;
        $espacio->save();
        return \Redirect::route('publica-images', array('id' => $espacio->id));
    }

    public function saveImages(Request $request) {
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
        return \Redirect::route('publica-amenities', array('id' => $request->espacio_id));
    }

    public function saveAmenities(Request $request) {
        $espacio = Espacio::find($request->id);
        $espacio->servicios()->sync($request->servicios);
        $espacio->save();
        return \Redirect::route('publica-caracteristicas', array('id' => $request->id));
    }

    public function saveCaracteristicas(Request $request) {
        $espacio = Espacio::find($request->id);
        $espacio->characteristics()->sync($request->characteristics);
        $espacio->save();
        return \Redirect::route('publica-caracteristicas', array('id' => $request->id));
    }
}
