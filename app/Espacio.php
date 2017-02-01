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
							'quanty',
							'adress',
							'city',
							'state',
							'country',
							'long',
							'lat'
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
     * @fn images()
     * @brief Funcion que retorna todas las imagenes asociadas al espacio
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
    	return $this->belongsToMany('App\categoria');
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
}
