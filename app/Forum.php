<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    protected $fillable = ['name', 'description'];

    public function threads()
    {
        return $this->hasMany('App\Thread');
    }

    public function tagGroups()
    {
        return $this->hasMany('App\TagGroup');
    }

    public function tags()
    {
        return $this->hasMany('App\Tag');
    }

    public function administrators()
    {
        return $this->belongsToMany('App\User', 'forum_users', 'forum_id', 'user_id');
    }
}
