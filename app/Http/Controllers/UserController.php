<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;


class UserController extends Controller
{
    // 所有user的操作都需要已登录
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function center(User $user)
    {
        $user = User::findOrFail($user->id);        
        return view('my_center')->with('user', $user);
    }

    public function threads(User $user)
    {
        $threads = User::findOrFail($user->id)->threads()->orderBy('created_at', 'desc')->paginate(10);
        return view('my_threads')->with('threads', $threads);
    }

}
