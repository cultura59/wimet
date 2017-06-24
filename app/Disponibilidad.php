<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Disponibilidad extends Model
{
	protected $table = 'disponibilidad';
    protected $fillable = ['dia', 'espacio_id', 'inicio', 'fin'];

    public function espacio()
    {
        return $this->hasOne('App\Espacio');
    }
}
