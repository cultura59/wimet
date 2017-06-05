<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
	protected $fillable = ['*'];

	/**
	 * @fn getMensajes()
	 * @brief funcion que retorna todos los mensajes asociados al evento
	 */
    public function mensajes() 
	{
		return $this->hasMany('App\Mensaje');
	}

	/**
	 * @fn getPropuestas()
	 * @brief funcion que retorna todas las propuestas asociados al evento
	 */
	public function propuestas()
	{
		return $this->hasMany('App\Propuesta');
	}
}
