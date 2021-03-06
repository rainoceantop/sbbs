<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Permission;

class PermissionController extends Controller
{
    /**
     * 权限id 1 = 查看帖子
     * 权限id 2 = 回复帖子
     * 权限id 3 = 创建帖子
     * 权限id 4 = 修改帖子
     * 权限id 5 = 用户查看
     * 权限id 6 = 用户注册
     * 权限id 7 = 用户修改
     */
    public static function store()
    {
        $permissions = [
            ['name' => '查看帖子'],
            ['name' => '回复帖子'],
            ['name' => '创建帖子'],
            ['name' => '修改帖子'],
            ['name' => '用户查看'],
            ['name' => '用户注册'],
            ['name' => '用户修改'],
        ];
        Permission::insert($permissions);
    }
}
