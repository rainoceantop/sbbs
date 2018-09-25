<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    // 对超级管理员通行
    public function before(User $user)
    {
        if($user->isSuperAdmin())
            return TRUE;
    }

    /**
     * 是否有权查看用户
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function view(User $user, User $model)
    {
        return $this->can($user, 4);
    }

    /**
     * 是否可以注册用户
     * 权限id 1 = 查看帖子
     * 权限id 2 = 回复帖子
     * 权限id 3 = 创建帖子
     * 权限id 4 = 用户查看
     * 权限id 5 = 用户注册
     * 权限id 6 = 用户编辑
     */
    public function register(User $user)
    {
        return $this->can($user, 5);
    }

    /**
     * 用户是否能够编辑
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        return $this->can($user, 6);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function restore(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function forceDelete(User $user, User $model)
    {
        //
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
