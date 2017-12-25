<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstiloEspacio extends Model
{
    protected $fillable = ['id', 'nombre'];
    protected $hidden = ['pivot'];
}
