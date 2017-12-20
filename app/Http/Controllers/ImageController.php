<?php

namespace App\Http\Controllers;

use App\Espacio;
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
        try {
            \Cloudinary::config(array(
                "cloud_name" => "wimet",
                "api_key" => "278198295249288",
                "api_secret" => "UCZYJFDClfelbwqG_CJajCWI-cw"
            ));

            //Busca la imagen actual y la borra
            $imagen = Image::find($id);
            $cloudinaryUrl = "http://res.cloudinary.com/wimet/image/upload/";
            $namesearch = str_replace($cloudinaryUrl, "", $imagen->name);
            \Cloudinary\Uploader::destroy($namesearch);
            $imagen->delete();
            return $id;
        }catch (\Exception $e) {
            return response('No se pudo borrar la imagen actual', 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \Cloudinary::config(array(
            "cloud_name" => "wimet",
            "api_key" => "278198295249288",
            "api_secret" => "UCZYJFDClfelbwqG_CJajCWI-cw"
        ));
        try {
            // Busca el espacio y asocia la nueva imagen
            $espacio = Espacio::find($request->espacio_id);
            $imagenPortada = $request->file('img_'.$request->imgorder);
            $destination_fotoprincipales = 'fotosespacios/' . $espacio->id . '/';
            $extension = "." . pathinfo($imagenPortada->getClientOriginalName(), PATHINFO_EXTENSION);
            $filename = "wimet_espacios_creativos_reuniones_producciones_eventos_retail_".$espacio->name."_".$request->imgorder.$extension;
            \Cloudinary\Uploader::upload($imagenPortada,
                array(
                    "public_id" => $destination_fotoprincipales . str_replace($extension, "", $filename)
                )
            );
            $cloudinaryUrl = "http://res.cloudinary.com/wimet/image/upload/";
            $imagen = new Image();
            $imagen->name = $cloudinaryUrl . $destination_fotoprincipales . $filename;
            $imagen->imgorder = $request->imgorder;
            $imagen->save();
            return $imagen;
        } catch (\Exception $e) {
            return response('Los campos no son correctos, ' . $e->getMessage(), 400);
        }
    }

    /**
     * Funcion que modifica los datos de la imagen
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update(Request $request, $id) {

    }

}
