<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TagGroup extends Model
{
    protected $fillable = ['forum_id', 'name'];

    public function forum()
    {
        return $this->belongsTo('App\Forum');
    }

    public function tags()
    {
        return $this->hasMany('App\Tag');
    }
}
