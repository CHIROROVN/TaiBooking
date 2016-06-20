<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'm_user';
    protected $primaryKey = 'u_id';
    public $timestamps  = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // protected $redirectTo = 'sys-adm/login';

    public function getPasswordAttribute(){
        return $this->u_passwd;
    } 

    public function setPasswordAttribute($value){
        $this->u_passwd = $value;
    }
}
