<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $username = 'username';

    protected $fillable = [
        'name', 'username', 'password', 'is_super_admin'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function threads()
    {
        return $this->hasMany('App\Thread');
    }

    public function groups()
    {
        return $this->belongsToMany('App\UserGroup', 'group_user', 'user_id', 'user_group_id');
    }

    // 判断是否超级用户
    public function isSuperAdmin()
    {
        return $this->is_super_admin;
    }
}
