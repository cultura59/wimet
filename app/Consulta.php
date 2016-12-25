<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    protected $fillable = ['reserva_desde', 'reserva_hasta', 'consulta'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
