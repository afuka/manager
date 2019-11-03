<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'nickname', 'avatar', 'mobile', 'email','password', 'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 获取用户的基本信息
     *
     * @return void
     */
    public function info()
    {
        return $this->hasOne('App\Models\UsersInfo', 'user_id');
    }

    /**
     * 获取用户第三方绑定账号信息
     *
     * @return void
     */
    public function oauths()
    {
        return $this->hasMany('App\Models\UsersOauth', 'user_id');
    }
}
