<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
	protected $fillable = [
							'nombre_evento',
							'titulo_cliente',
							'lead',
							'estilo_espacios_id',
							'invitados',
							'reserva_desde',
							'reserva_hasta',
							'user_id',
							'cliente_id',
							'espacio_id',
							'sub_total',
							'total_horas',
							'descripcion_consulta',
							'notas',
							'estado'
						];

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
