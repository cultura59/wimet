<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Espacio;
use Auth;

class EspacioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $espacios = Espacio::with('prices', 'categorias', 'servicios')->get();
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
        dd(Auth::user()->id);
        $espacio->user_id = Auth::user()->id;
        $espacio->name = $request->name;
        $espacio->description = $request->description;
        $espacio->quanty = $request->quanty;
        $espacio->adress = $request->adress;
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
                    ->with('categorias', 'servicios')
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
