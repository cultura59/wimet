<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Espacio;

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
        //$espacio = Espacio::create($request->all());
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
        $espacio = Espacio::find($id)
                    ->with(
                        'prices', 
                        'categorias', 
                        'servicios',
                        'estilosEspacio',
                        'rules',
                        'characteristics',
                        'access'
                    )
                    ->get();
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
    public function destroy($id)
    {
        $espacio = Espacio::find($id);
        $espacio->delete();
        return $id;
    }
}
