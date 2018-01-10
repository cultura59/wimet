<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropuestaServicios extends Model
{
    protected $fillable = ['sdescripcion', 'simporte', 'scantidad', 'stotal'];
}
