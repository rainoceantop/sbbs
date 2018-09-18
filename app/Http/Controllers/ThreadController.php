<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Forum;
use App\TagGroup;
use App\TagThread;
use Illuminate\Http\Request;
use App\Http\Resources\Thread as ThreadResource;

class ThreadController extends Controller
{

    public function index()
    {
        $threads = Thread::paginate(10);
        foreach($threads as $thread){
            $thread['tags'] = $thread->tags()->select(['tags.identity', 'tags.name', 'tags.color'])->get();
        }
        // dd($threads);

        return view('index')->with('threads', $threads);
    }

    public function create()
    {
        $forums = Forum::select(['id', 'name'])->get();
        $tagGroups = TagGroup::select(['id', 'forum_id', 'name'])->get();
        foreach($tagGroups as $tagGroup){
            $tagGroup['tags'] = TagGroup::find($tagGroup['id'])->tags()->select(['identity', 'tag_group_id', 'name'])->get()->toArray();
        }
        return view('thread_create')
            ->with('forums', $forums)
            ->with('tagGroups', json_encode($tagGroups, JSON_UNESCAPED_UNICODE));
    }

    public function store(Request $request)
    {   
        $request->validate([
            'user_id' => 'required',
            'title' => 'required|string',
            'body_md' => 'required',
            'tags' => 'required',
        ], [
            'user_id.required' => '请先登录',
            'title.required' => '标题不能为空',
            'body_md.required' => '内容不能为空',
            'tags.required' => '请至少选择一个标签',
        ]);

        // 判断是post还是put提交，post提交是创建，put提交是编辑
        $thread = $request->isMethod('post') ? new Thread() : Thread::findOrFail($request->thread_id);
        $thread->user_id = $request->user_id;
        $thread->forum_id = $request->input('select-forum');
        $thread->title = $request->title;
        $thread->body = $request->input('editormd-html-code');
        $thread->body_md = $request->input('body_md');
        // 保存thread
        $thread->save();

        // 将thread_id，tag_id关联
        foreach($request->tags as $tag){
            $tagThread = new TagThread();
            $tagThread->thread_id = $thread->id;
            $tagThread->tag_identity = $tag;
            $tagThread->save();
        }

        // 重定向路由至信息展示页，并携带thread信息
        return redirect()->route('thread.show', [$thread]);
    }

    public function show(Thread $thread)
    {
        // 获取此id
        $thread = Thread::findOrFail($thread->id);
        $tags = $thread->tags()->select(['tags.identity', 'tags.name', 'tags.color'])->get();
        // 渲染信息页面并携带id
        return view('thread_show')->with('thread', $thread)->with('tags', $tags);
    }

    public function edit(Thread $thread)
    {
        $thread = Thread::findOrFail($thread->id);
        return view('thread_create')->with('thread', $thread);
    }

    public function destroy(Thread $thread)
    {
        // $thread = Thread::findOrFail($thread->id);
        // $thread->delete();
        // return redirect()->back();
    }
}
