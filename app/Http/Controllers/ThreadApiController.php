<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;
use App\Http\Resources\Thread as ThreadResource;

class ThreadApiController extends Controller
{
    public function index()
    {
        $threads = Thread::paginate(3);
        return ThreadResource::collection($threads);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        // 获取此id的thread信息
        $thread = Thread::findOrFail($thread->id);
        // 返回thread信息
        return new ThreadResource($thread);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
