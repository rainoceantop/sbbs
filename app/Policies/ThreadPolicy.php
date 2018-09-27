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
     * 权限id 1 = 查看帖子
     * 权限id 2 = 回复帖子
     * 权限id 3 = 创建帖子
     * 权限id 4 = 修改帖子
     * 权限id 5 = 用户查看
     * 权限id 6 = 用户注册
     * 权限id 7 = 用户修改
     * 权限id 8 = 板块管理
     */
    public function view(User $user, Thread $thread)
    {
        // 帖子负责人可以查看
        if($user->id == $thread->user_id)
            return TRUE;
        // 版主可以查看
        if($this->is_forum_admin($user, $thread))
            return TRUE;
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
        // 版主自动获得发帖权
        if($user->forums()->count() > 0)
            return TRUE;
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
        // 帖子负责人可以回复
        if($user->id == $thread->user_id)
            return TRUE;
        // 版主可以回复
        if($this->is_forum_admin($user, $thread))
            return TRUE;
        return $this->can($user, 2);
    }

    // 用户是否有权更新
    public function update(User $user, Thread $thread)
    {
        // 帖子负责人可以更新
        if($user->id == $thread->user_id)
            return TRUE;
        // 版主可以更新
        if($this->is_forum_admin($user, $thread))
            return TRUE;
        // 否则只有加入更新权限的可以更新
        return $this->can($user, 4);
    }

    public function is_forum_admin(User $user, Thread $thread){
        $users = array_column($thread->forum->administrators()->get()->toArray(), 'id');
        if(in_array($user->id, $users))
            return TRUE;
        return FALSE;
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
