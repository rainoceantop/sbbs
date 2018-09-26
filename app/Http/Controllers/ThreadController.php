<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Forum;
use App\TagGroup;
use App\TagThread;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\Thread as ThreadResource;

class ThreadController extends Controller
{

    public function index(Request $request)
    {
        // 如果网站没有用户，转去注册页面注册一个超级管理员
        if(User::all()->count() == 0)
            return view('auth.register')->with('admin_register', TRUE);

        
        if(empty($request->type)){
            // 获取首页帖子
            $threads = Thread::where('is_filed', 0);
        } else {
            // 获取首页帖子
            $threads = Thread::where('is_filed', 0)->where('is_good', 1);
        }
        $threads = $threads->with('tags')->orderBy('is_top', 'desc')->orderBy('created_at', 'desc')->paginate(15);
        return view('index')->with('threads', $threads)
                            ->with('forum_id', 0);
    }

    public function create(Request $request)
    {
        if(Gate::allows('thread-create')){
            $forum_id = $request->fid;
            $forums = Forum::select(['id', 'name'])->get();
            $tagGroups = TagGroup::select(['id', 'forum_id', 'name'])->get();
            foreach($tagGroups as $tagGroup){
                $tagGroup['tags'] = TagGroup::find($tagGroup['id'])->tags()->select(['identity', 'tag_group_id', 'name'])->get()->toArray();
            }
            return view('thread_create')
                ->with('forums', $forums)
                ->with('tagGroups', json_encode($tagGroups, JSON_UNESCAPED_UNICODE))
                ->with('forum_id', $forum_id);
        }
        return "<script>alert('无权访问');history.go(-1);</script>";
    }

    public function store(Request $request)
    {   
        if($request->isMethod('post') && Gate::denies('thread-create'))
            return "<script>alert('无权新建');history.go(-1);</script>";
        if($request->isMethod('put') && Gate::denies('thread-update'))
            return "<script>alert('无权更新');history.go(-1);</script>";

        $requiement = [
            'select-forum' => 'required',
            'user_id' => 'required',
            'title' => 'required|string',
            'body_md' => 'required',
        ];
        $message = [
            'select-forum.required' => '请选择板块',
            'user_id.required' => '请先登录',
            'title.required' => '标题不能为空',
            'body_md.required' => '内容不能为空',
        ];

        $request->validate($requiement, $message);

        // 检测标签组是否不为空
        $have_tags = !empty(Forum::find($request->input('select-forum'))->tagGroups->toArray());
        // 如果标签组不为空，则验证
        if($have_tags){
            $request->validate(['tags' => 'required'], ['tags.required' => '请至少选择一个标签']);
        }

        // 判断是post还是put提交，post提交是创建，put提交是编辑
        $thread = $request->isMethod('post') ? new Thread() : Thread::findOrFail($request->thread_id);
        $thread->user_id = $request->user_id;
        $thread->forum_id = $request->input('select-forum');
        $thread->title = $request->title;
        $thread->body = $request->input('editormd-html-code');
        $thread->body_md = $request->input('body_md');
        // 保存thread
        $thread->save();

        if($have_tags){
            // 删除原先的关联
            $thread->tags()->detach();

            // 将thread_id，tag_id关联
            foreach($request->tags as $tag){
                $thread->tags()->attach($tag);
            }
        }

        // 重定向路由至信息展示页，并携带thread信息
        return redirect()->route('thread.show', [$thread]);
    }

    public function show(Thread $thread)
    {
        // 判断是否有权限访问
        if(Gate::denies('thread-view', $thread) && $thread->user_id != Auth::user()->id)
            return "<script>alert('无权访问');history.go(-1);</script>";

        // 获取此id
        $thread = Thread::findOrFail($thread->id);
        $replies = $thread->replies;
        $tags = $thread->tags()->select(['tags.tag_group_id', 'tags.identity', 'tags.name', 'tags.color'])->get();
        
        // 判断是否是版主或管理员访问
        $users = array_column($thread->forum->administrators()->get()->toArray(), 'id');
        $is_admin = (Auth::user()->is_super_admin == 1) || in_array(Auth::user()->id, $users);

        // 渲染信息页面并携带id
        return view('thread_show')->with('thread', $thread)
                                ->with('replies', $replies)
                                ->with('tags', $tags)
                                ->with('forum_id', $thread->forum->id)
                                ->with('is_admin', $is_admin);
    }

    public function edit(Thread $thread)
    {
        if(Gate::denies('thread-update'))
            return "<script>alert('无权更新');history.go(-1);</script>";
        $forum_id = $thread->id;
        $forums = Forum::select(['id', 'name'])->get();
        $tagGroups = TagGroup::select(['id', 'forum_id', 'name'])->get();
        foreach($tagGroups as $tagGroup){
            $tagGroup['tags'] = TagGroup::find($tagGroup['id'])->tags()->select(['identity', 'tag_group_id', 'name'])->get()->toArray();
        }
        return view('thread_create')
            ->with('thread', $thread)
            ->with('forums', $forums)
            ->with('tagGroups', json_encode($tagGroups, JSON_UNESCAPED_UNICODE))
            ->with('forum_id', $forum_id);
    }

    public function destroy(Thread $thread)
    {
        // $thread = Thread::findOrFail($thread->id);
        // $thread->delete();
        // return redirect()->back();
    }

    // 帖子归档
    public function setFiled(Thread $thread)
    {
        Thread::where('id', $thread->id)->update(['is_filed' => 1]);
    }
    // 帖子精华
    public function setGood(Thread $thread)
    {
        Thread::where('id', $thread->id)->update(['is_good' => 1]);
    }
    // 帖子置顶
    public function setTop(Thread $thread)
    {
        Thread::where('id', $thread->id)->update(['is_top' => 1]);
    }
    // 取消归档
    public function cancelFiled(Thread $thread)
    {
        Thread::where('id', $thread->id)->update(['is_filed' => 0]);
    }
    // 取消精华
    public function cancelGood(Thread $thread)
    {
        Thread::where('id', $thread->id)->update(['is_good' => 0]);
    }
    // 取消置顶
    public function cancelTop(Thread $thread)
    {
        Thread::where('id', $thread->id)->update(['is_top' => 0]);
    }
}
