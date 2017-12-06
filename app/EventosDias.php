<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventosDias extends Model
{
    protected $table = "eventos_dias";

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function evento()
    {
        return $this->belongsTo('App\Evento');
    }
}
