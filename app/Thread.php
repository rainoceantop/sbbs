<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $fillable = [
        'title', 'body'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function forum()
    {
        return $this->belongsTo('App\Forum');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'tag_thread', 'thread_id', 'tag_identity');
    }

    public function replies()
    {
        return $this->hasMany('App\Reply');
    }
}
