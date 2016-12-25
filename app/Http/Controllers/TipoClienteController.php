<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoCliente;

class TipoClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipoClientes = TipoCliente::all();
        return $tipoClientes;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tipoCliente = new TipoCliente($request->all());
        $tipoCliente->save();
        return $tipoCliente;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tipoCliente = TipoCliente::find($id);
        return $tipoCliente;
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
        $tipoCliente = TipoCliente::find($id);
        $tipoCliente->name = $request->name;
        $tipoCliente->save();
        return $tipoCliente;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tipoCliente = TipoCliente::find($id);
        $tipoCliente->delete();
        return $id;
    }
}
