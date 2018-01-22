<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use Notifiable;
    use SoftDeletes;

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
        'urllinkedin',
        'descuentos'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'pivot', 'password', 'remember_token', 'isAdmin',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function espacios() 
    {
        return $this->belongsToMany('App\Espacio')->select('id');
    }

    public function tipoCliente()
    {
        return $this->hasOne('App\TipoCliente');
    }

    public function consultas()
    {
        return $this->hasMany('App\Consulta');
    }

    public function eventos() 
    {
        return $this->hasMany('App\Evento');
    }

    public function senias() {
        return $this->hasMany('App\UserSenias');
    }

    /*
    * @name createOrUpdateHubspot()
    * @brief Funcion que crea o actualiza un usuario
    * @return Boolean
    */
    public function createOrUpdateHubspot($email, $arr) {
        $post_json = json_encode($arr);
        $keyHuspot = "153f6544-3085-41e5-98d0-80a3d435d496";
        
        $endpoint = 'https://api.hubapi.com/contacts/v1/contact?hapikey=' . $keyHuspot;
        $ch = @curl_init();
        @curl_setopt($ch, CURLOPT_POST, true);
        @curl_setopt($ch, CURLOPT_POSTFIELDS, $post_json);
        @curl_setopt($ch, CURLOPT_URL, $endpoint);
        @curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        @curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        @curl_close($ch);
        dd($ch);
        if($status_code == 200 || $status_code == 204) {
            return true;
        }else {
            return false;
        }
    }
}
