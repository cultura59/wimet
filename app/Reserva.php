<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
	protected $fillable = [
							'name',
							'reserva_desde',
							'reserva_hasta',
							'subtotal',
							'fee',
							'total',
							'paymentmethod',
							'numbercomprobant',
							'status'
						];

	/**
	* @fn espacio()
	* @brief Funcion que retorna el espacio asociado a la reserva
	*/
	public function espacio()
	{
		return $this->hasOne('App\Espacio');
	}

	/**
	* @fn cliente()
	* @brief Funcion que retorna el clienteg asociado a la reserva
	*/
	public function cliente()
	{
		return $this->hasOne('App\User');
	}
}
