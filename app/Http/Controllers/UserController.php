<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserController extends Controller
{
    // 所有user的操作都需要已登录
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if(Gate::denies('user-view', Auth::user()))
            return "<script>alert('无权访问');history.go(-1);</script>";

        $admins = User::where('is_super_admin', 1)->get();
        $users = User::where('is_super_admin', 0)->get();
        $category_id = 5;
        return view('admin_users')->with('users', $users)->with('user', Auth::user())->with('admins', $admins)->with('category_id', $category_id);
    }

    // 用户中心
    public function center(User $user)
    {
        if(Gate::denies('user-view', $user) && $user->id != Auth::user()->id)
            return "<script>alert('无权访问');history.go(-1);</script>";

        $user = User::findOrFail($user->id);
        $category_id = 0;
        $user_threads_count = $user->threads()->count();
        $user_good_threads = $user->threads()->where('is_good', 1)->count();
        $user_groups = implode(' , ', array_column($user->groups()->get()->toArray(), 'name'));
        $user_created_at = Carbon::parse($user->created_at)->toDateString();
        return view('my_center_info')->with('user', $user)
                                ->with('category_id', $category_id)
                                ->with('user_threads_count', $user_threads_count)
                                ->with('user_good_threads', $user_good_threads)
                                ->with('user_groups', $user_groups)
                                ->with('user_created_at', $user_created_at);
    }

    public function password(User $user)
    {
        // 如果访问用户和当前用户不是同一个人，返回
        if($user->id != Auth::user()->id)
            return "<script>alert('无权访问');history.go(-1);</script>";

        $user = User::find($user->id);
        $category_id = 0;
        return view('my_center_password')->with('user', $user)
                                         ->with('category_id', $category_id);
    }

    // 修改密码
    public function passwordSet(Request $request, User $user)
    {
        if($user->id != Auth::user()->id)
            return "<script>alert('无权访问');history.go(-1);</script>";
        
        $user = User::find($user->id);
        if(Hash::check($request->old_password, $user->password) && $request->new_password == $request->confirm_password){
            $user->password = Hash::make($request->new_password);
            $user->save();
            return redirect()->back()->with('success', '密码修改成功');
        }
        return redirect()->back()->with('fail', '密码修改失败，请确保输入正确');
        
    }

    public function avatar(User $user)
    {
        // 如果访问用户和当前用户不是同一个人，返回
        if($user->id != Auth::user()->id)
            return "<script>alert('无权访问');history.go(-1);</script>";
    
        $user = User::find($user->id);
        $category_id = 0;
        return view('my_center_avatar')->with('user', $user)
                                       ->with('category_id', $category_id);
    }

    public function avatarSet(Request $request)
    {
        if($request->user_id != Auth::user()->id)
            return "<script>alert('无权访问');history.go(-1);</script>";
            

        if ($request->hasFile('avatar')) {
            if ($request->file('avatar')->isValid()) {
                $extension = $request->avatar->extension();
                $acceptType = ['gif','jpeg','png','jpg','bmp'];
                if(!in_array($extension, $acceptType))
                    return 'fail';

                $avatar = $request->file('avatar');
                $path = 'storage/'.$avatar->store('avatars', 'public');
                $user = User::find($request->user_id);
                $user->avatar = $path;
                $user->save();
                return asset($path);
            } else{
                return 'fail';
            } 
        }else{
            return 'fail';
        }

    }

    // 获取用户帖子
    public function threads(User $user)
    {
        $user = User::findOrFail($user->id);
        $category_id = 1;
        $threads = $user->threads()->orderBy('created_at', 'desc')->paginate(15);
        return view('my_threads')->with('user', $user)->with('threads', $threads)->with('category_id', $category_id);
    }

    // 注册用户页面
    public function register()
    {
        $category_id = 6;
        return view('auth.center-register')->with('user', Auth::user())->with('category_id', $category_id);
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

    // 更新用户资料
    public function update(Request $request)
    {
        if(Gate::denies('user-update', Auth::user()))
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

    // 升级管理员
    public function upgrade(User $user)
    {
        User::where('id', $user->id)->update(['is_super_admin' => 1]);
    }

}
