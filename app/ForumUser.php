<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumUser extends Model
{
    protected $fillable = ['forum_id', 'user_id'];
    public $timestamps = FALSE;
}
