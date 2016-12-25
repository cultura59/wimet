<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
	protected $fillable = ['name'];

	public function categorias()
    {
        return $this->belongsTo('App\Categoria');
    }
}
