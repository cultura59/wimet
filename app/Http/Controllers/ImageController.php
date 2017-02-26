<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $images = Image::all();
        return $images;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $image = Image::where('espacio_id', $id)->get();
        return $image;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $image = Image::find($id);
        $image->delete();
        return $id;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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

}
