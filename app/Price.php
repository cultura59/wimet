<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $fillable = ['price', 'daily', 'cancellationflexibility', 'securitydeposit', 'cantidad_personas'];

    public function getCategories() 
	{
		return $this->hasMany('App\Categoria');
	}

	public function getRangos(){
        return $this->hasMany('App\RangoPrecios');
    }
}
