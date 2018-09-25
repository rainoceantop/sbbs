<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required' => '请输入名称',
            'username.required' => '请输入帐号',
            'username.unique' => '帐号已存在',
            'password.required' => '请输入密码',
            'password.min' => '密码不能小于6位',
            'password.confirmed' => '密码不一致'
        ]);
    }

    /**
     * 网站第一次注册，并创建权限
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        // 创建权限
        PermissionController::store();

        return User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'is_super_admin' => $data['is_super_admin'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
