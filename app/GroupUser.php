<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// user和usergroup的关联表model
class GroupUser extends Model
{
    protected $table = 'group_user';

    protected $fillable = ['user_id', 'user_group_id'];
}
