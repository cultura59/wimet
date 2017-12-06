<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RangoPrecios extends Model
{
    protected $table = 'rango_precios';
    protected $fillable = ['desde', 'hasta', 'precio'];
}
