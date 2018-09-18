<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['tag_group_id', 'identity', 'name', 'color'];

    public function group()
    {
        return $this->belongsTo('App\TagGroup');
    }

    public function threads()
    {
        return $this->belongsToMany('App\Thread', 'tag_thread', 'tag_identity', 'thread_id');
    }
}
