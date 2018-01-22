<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Propuesta extends Model
{
	protected $fillable = [
							'evento_id', 
							'estilo_espacios_id', 
							'invitados', 
							'reserva_desde', 
							'reserva_hasta',
							'user_id',
							'cliente_id',
							'espacio_id',
							'sub_total',
							'tu_pago',
							'comision',
							'vencimiento_propuesta',
							'deposito',
							'cancellationflexibility',
							'codigo',
							'monto_iva',
							'monto_con_iva',
							'fee',
							'total',
							'estado',
							'condiciones',
							'iva'
						];

    /**
     * @fn getPropuestasDias()
     * @brief funcion que retorna todos los dias asociados a la propuesta
     */
    public function dias() {
        return $this->hasMany('App\PropuestaDias');
    }

    public function servicios() {
    	return $this->hasMany('App\PropuestaServicios');
	}

	public function pagos() {
        return $this->hasMany('App\PropuestaPagos');
	}

	public function espacio() {
    	return $this->belongsTo('App\Espacio');
	}
}
