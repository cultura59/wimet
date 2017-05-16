<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'phone',
        'password',
        'imagesource',
        'businessName',
        'industry',
        'personaldescription',
        'city',
        'urlfacebook',
        'urllinkedin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'isAdmin',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function espacios() 
    {
        return $this->hasMany('App\Espacio');
    }

    public function tipoCliente()
    {
        return $this->hasOne('App\TipoCliente');
    }

    public function consultas()
    {
        return $this->hasMany('App\Consulta');
    }

    public function wishlist()
    {
        return $this->hasMany('App\wishlist');
    }
}
