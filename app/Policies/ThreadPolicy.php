<?php

namespace App\Policies;

use App\User;
use App\Thread;
use Illuminate\Auth\Access\HandlesAuthorization;

class ThreadPolicy
{
    use HandlesAuthorization;

    // 对超级管理员通行
    public function before(User $user)
    {
        if($user->isSuperAdmin())
            return TRUE;
    }

    /**
     * 是否有查看权限
     * 权限id 1 = 查看帖子
     * 权限id 2 = 回复帖子
     * 权限id 3 = 创建帖子
     * 权限id 4 = 用户查看
     * 权限id 5 = 用户注册
     * 权限id 6 = 用户编辑
     */
    public function view(User $user, Thread $thread)
    {
        return $this->can($user, 1);
    }

    /**
     * 用户是否有权创建帖子
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->can($user, 3);
    }


    /**
     * 用户是否有权回复
     *
     * @param  \App\User  $user
     * @param  \App\Thread  $thread
     * @return mixed
     */
    public function reply(User $user, Thread $thread)
    {
        return $this->can($user, 2);
    }

    public function can(User $user, $permission_id)
    {
        $user_groups = $user->groups()->with('permissions')->get()->toArray();
        foreach($user_groups as $user_group){
            $permissions = array_column($user_group['permissions'], 'id');
            if(in_array($permission_id, $permissions))
                return TRUE;
        }
        return FALSE;
    }
}
