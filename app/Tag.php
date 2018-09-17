<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name'];

    public function group()
    {
        return $this->belongsTo('App\TagGroup');
    }

    public function threads()
    {
        return $this->belongsToMany('App\Thread');
    }
}
