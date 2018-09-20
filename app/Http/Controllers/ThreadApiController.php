<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;
use App\Http\Resources\Thread as ThreadResource;

// API范本
class ThreadApiController extends Controller
{
    public function index()
    {
        $threads = Thread::paginate(3);
        // 返回所有thread
        return ThreadResource::collection($threads);
    }

    public function show($id)
    {
        // 获取此id的thread信息
        $thread = Thread::findOrFail($thread->id);
        // 返回thread信息
        return new ThreadResource($thread);
    }

}
