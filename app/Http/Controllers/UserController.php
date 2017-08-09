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
            $user->imagesource = ($request->imagesource) ? $request->imagesource : "/img/wimet_ic_avatar_black_big.svg";
            $user->isAdmin = 0;
            $user->save();
            $this->registerHubspot($request);
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
        $user->phone                = ($request->phone) ? $request->phone : "";
        $user->businessName         = ($request->businessName) ? $request->businessName : "";
        $user->industry             = ($request->industry) ? $request->industry : "";
        $user->personaldescription  = ($request->personaldescription) ? $request->personaldescription : "";
        $user->save();
        $this->registerHubspot($user);
        return view('dashboard.datos', array(
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
    public function updateUserConfirm(Request $request, $id)
    {
        try {
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
            $user->phone                = ($request->phone) ? $request->phone : "";
            $user->businessName         = ($request->businessName) ? $request->businessName : "";
            $user->industry             = ($request->industry) ? $request->industry : "";
            $user->personaldescription  = ($request->personaldescription) ? $request->personaldescription : "";
            $user->save();
            return $user;
        }catch(\Exception $e){
            return response('Los campos no son correctos', 400);
        }
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
                            ->orderBy('eventos.id', 'DESC')
                            ->get();

            return $eventos;
        }catch(\Exception $e){
            return response('Los campos no son correctos, error: ' . $e->getMessage(), 400);
        }
    }

    /**
     * Create a new user instance after a valid registration. into huspot
     *
     * @param  array  $data
     * @return User
     */
    protected function registerHubspot($data) {
        $arr = array(
            'properties' => array(
                array(
                    'property' => 'email',
                    'value' => $data->email
                ),
                array(
                    'property' => 'firstname',
                    'value' => $data->firstname
                ),
                array(
                    'property' => 'lastname',
                    'value' => $data->lastname
                ),
                array(
                    'property' => 'phone',
                    'value' => $data->phone
                ),
                array(
                    'property' => 'company',
                    'value' => $data->businessName
                ),
                array(
                    'property' => 'industry',
                    'value' => ''
                ),
                array(
                    'property' => 'city',
                    'value' => ''
                ),
                array(
                    'property' => 'urlfacebook',
                    'value' => ''
                ),
                array(
                    'property' => 'urllinkedin',
                    'value' => ''
                ),
                array(
                    'property' => 'tipo_clientes_id',
                    'value' => 1
                ),
                array(
                    'property' => 'fuente',
                    'value' => 'Website form'
                ),
                array(
                    'property' => 'esanfitrion',
                    'value' => false
                )
            )
        );
        $post_json = json_encode($arr);
        $keyHuspot = "153f6544-3085-41e5-98d0-80a3d435d496";
        
        $endpoint = 'https://api.hubapi.com/contacts/v1/contact?hapikey=' . $keyHuspot;
        $ch = @curl_init();
        @curl_setopt($ch, CURLOPT_POST, true);
        @curl_setopt($ch, CURLOPT_POSTFIELDS, $post_json);
        @curl_setopt($ch, CURLOPT_URL, $endpoint);
        @curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        @curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = @curl_exec($ch);
        $status_code = @curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_errors = curl_error($ch);
        @curl_close($ch);
        echo "curl Errors: " . $curl_errors;
        echo "\nStatus code: " . $status_code;
        echo "\nResponse: " . $response;
    }

    /**
     * Create/update a user instance after a valid registration. into huspot
     *
     * @param  array  $data
     * @return User
     */
    public function regitroStepHubspot($data, $step) {
        $arr = array(
            'properties' => array(
                array(
                    'property' => 'step_wimet_espacios',
                    'value' => $step
                )
            )
        );
        $post_json = json_encode($arr);
        $keyHuspot = "153f6544-3085-41e5-98d0-80a3d435d496";
        
        $endpoint = 'https://api.hubapi.com/contacts/v1/contact/createOrUpdate/email/'.$data->email.'/?hapikey=' . $keyHuspot;
        $ch = @curl_init();
        @curl_setopt($ch, CURLOPT_POST, true);
        @curl_setopt($ch, CURLOPT_POSTFIELDS, $post_json);
        @curl_setopt($ch, CURLOPT_URL, $endpoint);
        @curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        @curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = @curl_exec($ch);
        $status_code = @curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_errors = curl_error($ch);
        @curl_close($ch);
        Log::debug("curl Errors: " . $curl_errors);
        Log::debug("Status code: " . $status_code);
        Log::debug("Response: " . $response);
    }

    public function cambiarContraseniaRedes($id, $contra) {
        try {
            $user = User::find($id);
            $user->password =  bcrypt($contra);
            $user->save();
            return $user;
        }catch(\Exception $e){
            return response('No se pudo modificar la contraseña: ' . $e->getMessage(), 400);
        }
    }
}
