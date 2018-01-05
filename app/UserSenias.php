<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSenias extends Model
{
    protected $fillable = ['paymentid', 'vencimiento'];
}
