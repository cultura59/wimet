<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

	public function subCategory() 
	{
		return $this->hasMany('App\Subcategory');
	}

	public function servicios()
	{
		return $this->belongsToMany('App\Servicio');
	}
}
