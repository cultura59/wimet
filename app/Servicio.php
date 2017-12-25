<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
	protected $fillable = ['id', 'nombre', 'tipo'];
    protected $hidden = ['pivot'];
}
