<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Disponibilidad;
use App\Espacio;

class DisponibilidadController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $disponibilidades = $request->all();
        if(count($disponibilidades) > 0) {
            $espacio = Espacio::find($disponibilidades[0]['espacio_id']);
            $espacio->disponibilidad()->delete();
            $espacio->save();
        }
        foreach ($disponibilidades as $key => $disponibilidad) {
            try {
                $newDisponibilidad = new Disponibilidad;
                $newDisponibilidad->espacio_id = $disponibilidad['espacio_id'];
                $newDisponibilidad->dia = $disponibilidad['dia'];
                $newDisponibilidad->inicio = $disponibilidad['inicio'];
                $newDisponibilidad->fin = $disponibilidad['fin'];

                $newDisponibilidad->save();
            } catch (\Exception $e) {
                return response('No se pudo crear para este espacio, ' . $e->getMessage(), 404);
            }
        }
        return response('La disponibilidad fue creada', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $disponibilidades = Disponibilidad::where('espacio_id', $id)->get();
            return $disponibilidades;
        } catch (\Exception $e) {
            return response('No se encontro disponibilidad para este espacio', 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }
}
