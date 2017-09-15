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
        $image = Image::where('espacio_id', $id)
            ->orderBy('imgorder')
            ->get();
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
        \Cloudinary::config(array( 
          "cloud_name" => "wimet", 
          "api_key" => "278198295249288", 
          "api_secret" => "UCZYJFDClfelbwqG_CJajCWI-cw" 
        ));
        $image = Image::find($id);
        $arrNameImage = explode(".", $image->name);
        $response = \Cloudinary\Uploader::destroy($arrNameImage[0]);
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
            $filename_imagesEspacio = str_replace(' ', '_', str_random(8).'_'.$img->getClientOriginalName());

            $image = new Image;
            $image->name = $destination_fotoprincipales . $filename_imagesEspacio;
            $image->espacio_id = $request->espacio_id;
            //$image->save();

            $response = \Cloudder::upload($img->getClientOriginalName(), 1);
            dd($response);
            //$img->move($destination_fotoprincipales, $filename_imagesEspacio);
        }
    }

    /**
     * Funcion que modifica los datos de la imagen
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update(Request $request, $id) {
        try {
            $imagen = Image::find($id);
            $imagen->imgorder = $request->imgorder;
            $imagen->save();
            return $imagen;
        } catch (\Exception $e) {
            return response('Los campos no son correctos, ' . $e->getMessage(), 400);
        }
    }

}
