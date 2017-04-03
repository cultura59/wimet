<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $fillable = ['price'];

    public function getCategories() 
	{
		return $this->hasMany('App\Categoria');
	}
}
