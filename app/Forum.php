<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    protected $fillable = ['name'];

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
}
