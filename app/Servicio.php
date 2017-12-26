<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
	protected $fillable = ['id', 'nombre', 'tipo', 'icon'];
    protected $hidden = ['pivot'];
}
