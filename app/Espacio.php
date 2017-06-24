<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Espacio extends Model
{
	protected $fillable = [
                            'user_id',
                            'name',
                            'description',
                            'rule',
                            'politcancel',
                            'quantyrooms',
                            'quantybathrooms',
                            'floor',
                            'surface',
                            'quanty',
                            'foot',
                            'seated',
                            'adress',
                            'city',
                            'state',
                            'country',
                            'long',
                            'lat',
                            'securitydeposit',
                            'image360',
                            'cancellationflexibility'
						];
	/**
	 * @fn user()
	 * @brief funcion que retorna el usuario asociado al espacio
	 */
	public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * @fn prices()
     * @brief Funcion que retorna todas las precios asociadas al espacio
     */
    public function prices()
    {
        return $this->hasMany('App\Price');
    }

    /**
     * @fn priceByCategory()
     * @brief Funcion que retorna el precio asociadas al espacio por categoria
     */
    public function priceByCategory()
    {
        return $this->prices()->where('categoria_id', \Request::input('categoria'));
    }

    /**
     * @fn images()
     * @brief Funcion que retorna todas las imagenes asociadas al espacio
     */
    public function images()
    {
        return $this->hasMany('App\Image');
    }

    /**
     * @fn categorias()
     * @brief Funcion que retorna las categorias asociadas al espacio
     */
    public function categorias()
    {
    	return $this->belongsToMany('App\Categoria');
    }

    /**
     * @fn servicios()
     * @brief Funcion que retorna los servicios asociados al espacio
     */
    public function servicios()
    {
    	return $this->belongsToMany('App\Servicio');
    }

    /**
     * @fn tags()
     * @brief Funcion que retorna los tags asociados al espacio
     */
    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }

    /**
    * @fn consultas()
    * @brief Funcion que retorna las consultas asociadas al espacio
    */
    public function consultas()
    {
        return $this->hasMany('App\Consulta');
    }

    /**
    * @fn tiposEspacio()
    * @brief Funcion que retorna los tipos asociados al espacio
    */
    public function estilosEspacio()
    {
        return $this->belongsToMany('App\EstiloEspacio');
    }

    /*
     * @fn rules()
     * @brief Funcion que retorna las reglas asociadas al espacio
     */
    public function rules()
    {
        return $this->belongsToMany('App\Rules');
    }

    /*
     * @fn characteristics()
     * @brief Funcion que retorna las Caracteristics asociadas al espacio
     */
    public function characteristics()
    {
        return $this->belongsToMany('App\Characteristics');
    }

    /*
     * @fn access()
     * @brief Funcion que retorna las access asociadas al espacio
     */
    public function access()
    {
        return $this->belongsToMany('App\Access');
    }

    /*
     * @fn disponibilidad()
     * @brief Funcion que retorna las disponibilidades asociadas al espacio
     */
    public function disponibilidad()
    {
        return $this->hasMany('App\Disponibilidad');
    }
}
