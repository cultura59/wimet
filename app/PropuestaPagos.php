<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropuestaPagos extends Model
{
    protected $fillable = ['pdescripcion', 'ptotal', 'pvencimiento', 'pestado'];
}
