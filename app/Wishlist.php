<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    /**
     * Get all of the owning favoritos models.
     */
    public function favoritos()
    {
        return $this->morphTo();
    }
}
