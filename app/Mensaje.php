<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
	protected $fillable = ['evento_id', 'user_id', 'mensaje'];
}
