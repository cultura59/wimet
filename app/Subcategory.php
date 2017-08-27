<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $hidden = ['categoria_id', 'created_at', 'updated_at', 'deleted_at'];

	public function categorias()
    {
        return $this->belongsTo('App\Categoria');
    }
}
