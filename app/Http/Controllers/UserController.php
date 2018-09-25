<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // 所有user的操作都需要已登录
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = User::where('is_super_admin', 0)->get();
        return view('admin_users')->with('users', $users)->with('user', Auth::user());
    }

    // 用户中心
    public function center(User $user)
    {
        if(Gate::denies('user-view', $user) && $user->id != Auth::user()->id)
            return "<script>alert('无权访问');history.go(-1);</script>";

        $user = User::findOrFail($user->id);        
        return view('my_center')->with('user', $user);
    }

    // 获取用户帖子
    public function threads(User $user)
    {
        $user = User::findOrFail($user->id);
        $threads = $user->threads()->orderBy('created_at', 'desc')->paginate(10);
        return view('my_threads')->with('user', $user)->with('threads', $threads);
    }

    // 注册用户页面
    public function register()
    {
        return view('auth.center-register')->with('user', Auth::user());
    }

    // 普通用户注册
    public function create(Request $request)
    {
        if(Gate::denies('user-register'))
            return "<script>alert('无权注册');history.go(-1);</script>";

        $requiement = [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ];
        $message = [
            'name.required' => '请输入名称',
            'username.required' => '请输入帐号',
            'username.unique' => '帐号已存在',
            'password.required' => '请输入密码',
            'password.min' => '密码不能小于6位',
            'password.confirmed' => '密码不一致'
        ];
        // 验证注册数据
        $request->validate($requiement, $message);

        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->back()->with('success', '用户注册成功');
    }

    public function update(Request $request)
    {
        if(Gate::denies('user-update', new User))
            return "<script>alert('无权修改');history.go(-1);</script>";


        $requiement = [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
        ];
        $message = [
            'name.required' => '请输入名称',
            'username.required' => '请输入帐号',
        ];
        // 验证注册数据
        $request->validate($requiement, $message);

        $user = User::find($request->id);
        $user->name = $request->name;
        $user->username = $request->username;
        if(!empty($request->password))
            $user->password = Hash::make($request->password);
        $user->update();
        return redirect()->back();
    }

}
