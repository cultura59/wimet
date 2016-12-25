<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
	protected $fillable = ['name'];

	public function subCategory() 
	{
		return $this->hasMany('App\Subcategory');
	}

	public function servicios() 
	{
		return $this->hasMany('App\Servicio');
	}
}
