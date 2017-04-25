<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

        return $user;
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
