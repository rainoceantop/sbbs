<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    protected $fillable = ['name'];

    public function tagGroups()
    {
        return $this->hasMany('App\TagGroup');
    }
}
