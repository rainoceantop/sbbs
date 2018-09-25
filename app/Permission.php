<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['name'];
    public function groups()
    {
        return $this->belongsToMany('App\UserGroup', 'group_permission', 'permission_id', 'group_id');
    }
}
