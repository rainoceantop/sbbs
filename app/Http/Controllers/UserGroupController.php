<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserGroup;
use App\User;
use App\GroupUser;

class UserGroupController extends Controller
{
    // 返回用户组管理视图
    public function index()
    {
        $userGroups = UserGroup::with('users')->get();
        foreach($userGroups as $userGroup){
            // 关联获取到的数据携带pivot一栏,一级更新和创建的事件栏，切割掉再对比差集
            $userGroup['notJoinYetUsersId'] = array_diff(array_column(User::all()->toArray(), 'id'), array_column($userGroup->users->toArray(), 'id'));
        }
        return view('admin_groups')->with('userGroups', $userGroups);
    }

    public function store(Request $request)
    {
        UserGroup::create($request->all());
        return redirect()->back();
    }

    public function addUser(Request $request)
    {
        $user_group_id = $request->user_group_id;
        $add_users = $request->add_users;
        $del_users = $request->del_users;
        // 添加用户
        if(!empty($add_users)){
            foreach($add_users as $user){
                $groupUser = new GroupUser();
                $groupUser->user_group_id = $user_group_id;
                $groupUser->user_id = $user;
                $groupUser->save();
            }
        }
        // 删除用户
        $this->delUser($user_group_id, $del_users);
        return redirect()->back();
    }

    public function delUser($user_group_id, $del_users)
    {
        if(!empty($del_users)){
            foreach($del_users as $user){
                GroupUser::where('user_group_id', $user_group_id)->where('user_id', $user)->delete();
            }
        }
    }

    public function destroy(Request $request)
    {
        UserGroup::destroy($request->groups);
        return redirect()->back();
    }
}
