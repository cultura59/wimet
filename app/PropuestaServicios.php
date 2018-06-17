<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropuestaServicios extends Model
{
    protected $fillable = ['propuesta_id', 'sdescripcion', 'simporte', 'scantidad', 'stotal'];
}
