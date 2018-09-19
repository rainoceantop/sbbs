<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $table = 'replies';

    protected $fillable = [
        'thread_id',
        'body',
        'index',
        'from_user_id',
        'to_user_id'
    ];

    public function thread()
    {
        return $this->belongsTo('App\Thread');
    }
}
