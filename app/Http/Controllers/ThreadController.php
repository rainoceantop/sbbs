<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;
use App\Http\Resources\Thread as ThreadResource;


class ThreadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $threads = Thread::paginate(3);
        return ThreadResource::collection($threads);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('thread_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateThread($request);
        // 判断是post还是put提交，post提交是创建，put提交是编辑
        $thread = $request->isMethod('post') ? new Thread() : Thread::findOrFail($request->thread_id);
        $thread->user_id = $request->user_id;
        $thread->title = $request->title;
        $thread->body = $request->input('editormd-html-code');
        // $thread->body_md = $request->input('editormd-markdown-doc');
        // 保存thread
        $thread->save();
        // 重定向路由至信息展示页，并携带thread信息
        return redirect()->route('getThread', [$thread]);
    }

    protected function validateThread(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function get(Thread $thread)
    {
        // 获取此id的thread信息
        $thread = Thread::findOrFail($thread->id);
        // 返回thread信息
        return new ThreadResource($thread);
    }

    public function show(Thread $thread){
        // 获取此id
        $thread = Thread::findOrFail($thread->id);
        // 渲染信息页面并携带id
        return view('thread_show')->with('thread', $thread);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        $thread = Thread::findOrFail($thread->id);
        return view('thread_create')->with('thread', $thread);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thread $thread)
    {
        //
    }
}
