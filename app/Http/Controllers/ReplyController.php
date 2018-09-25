<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ReplyController extends Controller
{
    public function store(Request $request)
    {
        if(Gate::allows('thread-reply', new Thread)){
            Reply::create($request->all());
            return redirect()->back();
        }
        return "<script>alert('无权回复');history.go(-1);</script>";
    }
}
