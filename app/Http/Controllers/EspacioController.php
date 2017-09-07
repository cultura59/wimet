<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use App\Espacio;
use App\Image;
use App\Price;
use App\User;
use DB;
use Mail;
use Validator;
use Symfony\Component\HttpFoundation\Response;
use Auth;
use App\Mail\NuevoEspacio;

class EspacioController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $espacios = Espacio::with(
                'prices', 
                'categorias', 
                'servicios',
                'estilosEspacio',
                'rules',
                'images',
                'characteristics',
                'access'
            )->get();
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
        try {
            $espacio = new Espacio();
            $espacio->user_id = $request->user_id;
            $espacio->name = $request->name;
            $espacio->description = $request->description;
            $espacio->quantyrooms = ($request->quantyrooms) ? $request->quantyrooms : null;
            $espacio->quantybathrooms = ($request->quantyrooms) ? $request->quantyrooms : null;
            $espacio->floor = ($request->floor) ? $request->floor : null;
            $espacio->surface = ($request->surface) ? $request->surface : null;
            $espacio->seated = ($request->seated) ? $request->seated : null;
            $espacio->quanty = ($request->quanty) ? $request->quanty : null;
            $espacio->adress = ($request->adress) ? $request->adress : null;
            $espacio->type = ($request->type) ? $request->type : null;
            $espacio->city = ($request->city) ? $request->city : null;
            $espacio->state = ($request->state) ? $request->state : null;
            $espacio->country = ($request->country) ? $request->country : null;
            $espacio->long = ($request->long) ? $request->long : null;
            $espacio->lat = ($request->lat) ? $request->lat : null;
            $espacio->step = ($request->step) ? $request->step : null;
            $espacio->status = false;
            $espacio->save();
            if($request->estilos) {
                $espacio->estilosEspacio()->sync($request->estilos);
            }
            return $espacio;
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
        $espacio = Espacio::where('id', $id)
                    ->with(
                        'prices', 
                        'categorias', 
                        'servicios',
                        'estilosEspacio',
                        'rules',
                        'images',
                        'characteristics',
                        'access'
                    )
                    ->first();
        $espacio->description = strip_tags($espacio->description);
        return $espacio;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getEspacio($categoriaId, $id)
    {
        $espacio = DB::table('espacios')
                    ->join('categoria_espacio', 'espacios.id', '=', 'categoria_espacio.espacio_id')
                    ->join('prices', function($join) {
                        $join->on('espacios.id', '=', 'prices.espacio_id');
                        $join->on('categoria_espacio.categoria_id', '=', 'prices.categoria_id');
                    })
                    ->join('images', 'espacios.id', '=', 'images.espacio_id')
                    ->join('users', 'espacios.user_id', '=', 'users.id')
                    ->select('espacios.name', 'espacios.quanty', 'images.name as image', 'prices.price', 'users.imagesource')
                    ->where([
                        ['espacios.id', '=', $id],
                        ['categoria_espacio.categoria_id', '=', $categoriaId],
                    ])
                    ->get();
        return $espacio;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $espacio = Espacio::find($id);
        $espacio->delete();
        return $id;
    }

    /**
    * @fn saveEspacioWithoutData()
    * @brief Funcion que guarda un espacio desde la vista registracion espacio
    * @param Object $request
    * @return redirect to public-categoria
    */
    public function saveEspacioWithoutData(Request $request) {
        try {
            $emails = ['adrian@wimet.co', 'alejandro@wiemt.co', 'federico@wimet.co'];

            $user = User::find($request->user_id);
            // Se crea el espacio
            $espacio = new Espacio($request->all());
            $espacio->status = false;
            $espacio->save();
            // Se guardan las categorias asociadas al espacio
            $categorias = $espacio->estilosEspacio()->sync($request->estilos);
            // Se modifica el tipo de usuario en Hubspot
            $this->registerHubspot($user);
            // Envia email a wimet informando el nuevo espacio
            Mail::to($emails)
                ->queue(new NuevoEspacio($espacio, $user, $categorias));
            return $espacio;
        }catch(\Exception $e){
            return response('Los campos no son correctos', 400);
        }
    }

    /**
    * @fn saveEspacio()
    * @brief Funcion que guarda un espacio desde la vista registracion espacio
    * @param Object $request
    * @return redirect to public-categoria
    */
    public function saveEspacio(Request $request) {
        try {
            $espacio = Espacio::find($request->id);
            $espacio->name = $request->name;
            $espacio->description = nl2br($request->description);
            $espacio->step = ($espacio->step == 4) ? $espacio->step : $request->step;
            $espacio->save();
            if($espacio->step != 4) {
                $user = User::find($espacio->user_id);
                $this->regitroStepHubspot($user, $request->step);
            }
            return $espacio;
        }catch(\Exception $e){
            return response('Los campos no son correctos')->status(400);
        }
    }

    /**
    * @fn saveCategory()
    * @brief Funcion que asocia categorias a un espacio
    * @param Object $request
    * @return redirect to public-detalles
    */
    public function saveCategory(Request $request) {
        $espacio = Espacio::find($request->id);
        if(!$request->categorias){
            $request->session()->flash('alert-danger', 'Debe seleccionar alguna actividad');
            return \Redirect::route('publica-categoria', array('id' => $espacio->id));
        }
        $espacio->categorias()->sync($request->categorias);
        $espacio->save();
        $oldPrices = $espacio->prices();
        $espacio->prices()->delete();
        $espacio->save();
        foreach ($request->categorias as $key => $categoria)
        {
            $encontro = false;
            $objEncontrado = null;

            foreach ($oldPrices->get() as $key => $oldPrice) {
                var_dump((int)$categoria . " " . $oldPrice->categoria_id);
                if((int)$categoria == $oldPrice->categoria_id) {
                    $objEncontrado = $oldPrice;
                }
            }
            $price = new Price;
            if($encontro){
                $price->espacio_id      = $objEncontrado->espacio_id;
                $price->categoria_id    = $objEncontrado->categoria_id;
                $price->price           = $objEncontrado->price;
                $price->daily           = $objEncontrado->daily;
                $price->minhours        = $objEncontrado->minhours;
                $price->status          = $objEncontrado->status;
            }else {
                $price->espacio_id      = $espacio->id;
                $price->categoria_id    = $categoria;
                $price->price           = 0;
                $price->daily           = 0;
                $price->minhours        = 0;
                $price->status          = true;
            }
            $price->save();
        }
        return \Redirect::route('publica-detalles', array('id' => $request->id));
    }

    /**
    * @fn saveAccess()
    * @brief Funcion que asocia accesos a un espacio
    * @param Object $request
    * @return redirect to public-invidatos
    */
    public function saveAccess(Request $request) {
        $espacio = Espacio::find($request->id);
        if($request->quantyrooms) {
            $espacio->quantyrooms = $request->quantyrooms;
        }
        if($request->quantybathrooms) {
            $espacio->quantybathrooms = $request->quantybathrooms;
        }
        if($request->floor) {
            $espacio->floor = $request->floor;
        }
        if($request->surface) {
            $espacio->surface = $request->surface;
        }
        if($request->access) {
            $espacio->access()->sync($request->access);
        }
        $espacio->save();
        return \Redirect::route('publica-invidatos', array('id' => $request->id));
    }

    /**
    * @fn saveInvitados()
    * @brief Funcion que asocia cantidad invitados a un espacio
    * @param Object $request
    * @return redirect to public-maps
    */
    public function saveInvitados(Request $request) {
        $espacio = Espacio::find($request->id);
        if($request->quanty) {
            $espacio->quanty = $request->quanty;
        }
        if($request->foot) {
            $espacio->foot = $request->foot;
        }
        if($request->seated) {
            $espacio->seated = $request->seated;
        }
        $espacio->save();
        return \Redirect::route('publica-maps', array('id' => $espacio->id));
    }

    /**
    * @fn saveAdress()
    * @brief Funcion que asocia direccion a un espacio
    * @param Object $request
    * @return redirect to public-images
    */
    public function saveAdress(Request $request) {
        $espacio = Espacio::find($request->id);
        if($request->route && $request->street_number) {
            $espacio->adress = $request->route . " " . $request->street_number;
        }
        if($request->locality) {
            $espacio->state = $request->locality;
        }
        if($request->administrative_area_level_1) {
            $espacio->city = $request->administrative_area_level_1;
        }
        if($request->country) {
            $espacio->country = $request->country;
        }
        if($request->lat) {
            $espacio->lat = $request->lat;
        }
        if($request->long) {
            $espacio->long = $request->long;
        }
        $espacio->step = ($espacio->step == 4) ? $espacio->step : 2;
        $espacio->save();
        if($espacio->step == 2) {
            $user = User::find($espacio->user_id);
            $this->regitroStepHubspot($user, 2);
        }
        return \Redirect::route('publica-steps', array(
                "espacioId" => $espacio->id
            )
        );
    }

    /**
    * @fn saveImages()
    * @brief Funcion que asocia imagenes a un espacio
    * @param Object $request
    * @return redirect to public-amenities
    */
    public function saveImages(Request $request, $id) {
        \Cloudinary::config(array( 
          "cloud_name" => "wimet", 
          "api_key" => "278198295249288", 
          "api_secret" => "UCZYJFDClfelbwqG_CJajCWI-cw" 
        ));
        if($request->hasFile('file')) {
            // upload the image //
            $imagesEspacio = $request->file('file');
            $destination_fotoprincipales = 'fotosespacios/';
            $filename_imagesEspacio = str_replace(' ', '_', str_random(8).'_'.$imagesEspacio->getClientOriginalName());
            $extension = "." . pathinfo($imagesEspacio->getClientOriginalName(), PATHINFO_EXTENSION);

            $image = new Image;
            $image->name = $destination_fotoprincipales . $filename_imagesEspacio;
            $image->espacio_id = $id;
            $image->save();
            $response = \Cloudinary\Uploader::upload($imagesEspacio, 
                array(
                    "public_id" => $destination_fotoprincipales . str_replace($extension, "", $filename_imagesEspacio)
                )
            );
            return $image;
        }
    }

    /**
    * @fn saveAmenities()
    * @brief Funcion que asocia amenities a un espacio
    * @param Object $request
    * @return redirect to public-caracteristicas
    */
    public function saveAmenities(Request $request) {
        if($request->servicios) {
            $espacio = Espacio::find($request->id);
            $espacio->servicios()->sync($request->servicios);
            $espacio->save();
        }
        return \Redirect::route('publica-titulo', array('id' => $request->id));
    }

    /**
    * @fn saveImages()
    * @brief Funcion que asocia imagenes a un espacio
    * @param Object $request
    * @return redirect to public-caracteristicas
    */
    public function saveCaracteristicas(Request $request) {
        if($request->characteristics) {
            $espacio = Espacio::find($request->id);
            $espacio->characteristics()->sync($request->characteristics);
            $espacio->save();
        }
        return \Redirect::route('publica-amenities', array('id' => $request->id));
    }

    /**
    * @fn saveRules()
    * @brief Funcion que asocia las reglas a un espacio
    * @param Object $request
    * @return redirect to public-caracteristicas
    */
    public function saveRules(Request $request) {
        if($request->rules) {
            $espacio = Espacio::find($request->id);
            $espacio->rules()->sync($request->rules);
            $espacio->save();
        }
        return \Redirect::route('publica-prices', array('id' => $request->id));
    }

    /**
    * @fn savePrice()
    * @brief Funcion que asocia precios a un espacio
    * @param Object $request
    * @return redirect to public-caracteristicas
    */
    public function savePrice(Request $request) {
        foreach ($request->categories as $key => $cat) {
            $price = Price::find($cat['id']);
            if($cat['espacio_id']) {
                $price->espacio_id = $cat['espacio_id'];
            }
            if($cat['categoria_id']) {
                $price->categoria_id = $cat['categoria_id'];
            }
            if($cat['price']) {
                $price->price = $cat['price'];
            }
            if($cat['daily']) {
                $price->daily = $cat['daily'];
            }
            if($cat['minhours']) {
                $price->minhours = $cat['minhours'];
            }
            $price->status = $cat['status'];
            $price->save();
        }
        return response('Los precios fueron modificados', 200);
    }

    /**
    * @fn saveCancelacion()
    * @brief Funcion que asocia cantidad invitados a un espacio
    * @param Object $request
    * @return redirect to public-maps
    */
    public function saveCancelacion(Request $request) {
        $espacio = Espacio::find($request->id);
        if($request->securitydeposit) {
            $espacio->securitydeposit = $request->securitydeposit;
        }
        if($request->cancellationflexibility) {
            $espacio->cancellationflexibility = $request->cancellationflexibility;
        }
        $espacio->step = 4;
        $espacio->save();
        if($espacio->step == 4) {
            $user = User::find($espacio->user_id);
            $this->regitroStepHubspot($user, 4);
        }
        return \Redirect::route('publica-steps', array(
                "espacioId" => $espacio->id
            )
        );
    }

    /**
    * @fn saveWishlist()
    * @brief Funcion que asocia un espacio a un usuaio
    * @param Object $request
    * @return true o false
    */
    public function saveWishlist(Request $request) {
        $user = User::find($request->clientId);
        if($user->id == null){
            return false;
        }
        $user->wishlist()->sync($request->espacio_id);
        return true;
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
                    'property' => 'esanfitrion',
                    'value' => true
                ),
                array(
                    'property' => 'step_wimet',
                    'value' => 1
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
                    'property' => 'step_wimet',
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
    }
}
