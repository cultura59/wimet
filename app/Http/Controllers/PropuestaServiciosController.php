<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PropuestaServicios;
use DB;

class PropuestaServiciosController extends Controller
{
    /**
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function show($id) {
        try {
            $servicio = PropuestaServicios::find($id);
            return $servicio;
        }catch (\Exception $e) {
            return response('No se pudo encontrar el servicio', 500);
        }
    }

    /**
     * @fn store()
     * @param Request $request
     * @return PropuestaServicios|\Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function store(Request $request) {
        DB::beginTransaction();
        try {
            $servicio = new PropuestaServicios();
            $servicio->save($request->all());
            DB::commit();
            return $servicio;
        }catch (\Exception $e) {
            DB::rollback();
            return response('No se pudo agregar el nuevo servicio', 500);
        }
    }

    /**
     * @fn update()
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update(Request $request, $id) {
        DB::beginTransaction();
        try {
            $servicio = PropuestaServicios::find($id);
            $servicio->update($request->all());
            DB::commit();
            return $servicio;
        }catch (\Exception $e) {
            DB::rollback();
            return response('No se pudo modificar el servicio', 500);
        }
    }

    /**
     * @fn delete()
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function destroy($id) {
        DB::beginTransaction();
        try {
            $servicio = PropuestaServicios::find($id);
            $servicio->delete();
            DB::commit();
            return response('Se borro el servicio', 200);
        }catch (\Exception $e) {
            DB::rollback();
            return response('No se pudo borrar el servicio', 500);
        }
    }
}
