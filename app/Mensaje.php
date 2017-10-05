<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
	protected $fillable = ['evento_id', 'user_id', 'mensaje'];

    /**
     * @fn user()
     * @brief funcion que retorna el usuario asociado al espacio
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
