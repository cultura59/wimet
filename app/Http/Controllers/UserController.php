<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $user = new User;
            $user->firstname = $request->firstname;
            $user->lastname = $request->lastname;
            $user->email = $request->email;
            $user->imagesource = ($request->imagesource) ? $request->imagesource : null;
            $user->password =  bcrypt($request->password);
            $user->tipo_clientes_id = 1;
            $user->isAdmin = 0;
            $user->save();
            return $user;
        }catch(\Exception $e){
            return response('Los campos no son correctos', 400);
        }
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
            $user = User::where('email', $id)->first();
            if($user == null) {
                return response('No se encontro el usuario', 400);
            }else {
                return $user;
            }
            return $user;
        }catch(\Exception $e){
            return response('Los campos no son correctos', 500);
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
        $user = User::find($id);
        return view('users.edit', array(
            'user' => $user
        ));
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
        $user = User::find($id);
        if ($request->hasFile('imagesource')) {
            // upload the image //
            $imageUser                      = $request->file('imagesource');
            $destination_fotoprincipales    = 'avatars/';
            $filename_imageUser             = str_random(8).'_'.$imageUser->getClientOriginalName();

            $imageUser->move($destination_fotoprincipales, $filename_imageUser);

            $user->imagesource          = "/" . $destination_fotoprincipales . $filename_imageUser;
        }

        $user->firstname            = $request->firstname;
        $user->lastname             = $request->lastname;
        $user->email                = $request->email;
        $user->phone                = $request->phone;
        $user->businessName         = $request->businessName;
        $user->industry             = $request->industry;
        $user->personaldescription  = $request->personaldescription;
        $user->save();

        $user = User::find($id);
        return view('users.edit', array(
            'user' => $user
        ));
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

    /**
     * Show the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getEventos($id) {
        try {
            $eventos = DB::table('eventos')
                            ->join('users', 'eventos.cliente_id', '=', 'users.id')
                            ->select(
                                'eventos.id',
                                'eventos.created_at',
                                'eventos.reserva_desde',
                                'users.firstname',
                                'eventos.nombre_evento',
                                'eventos.lead',
                                'eventos.estado'
                            )
                            ->where('eventos.user_id', $id)
                            ->get();

            return $eventos;
        }catch(\Exception $e){
            return response('Los campos no son correctos, error: ' . $e->getMessage(), 400);
        }
    }
}
