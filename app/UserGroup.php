<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    protected $fillable = ['name'];

    public function users()
    {
        return $this->belongsToMany('App\User', 'group_user', 'user_group_id', 'user_id');
    }
}
