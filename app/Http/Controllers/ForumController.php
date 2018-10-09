<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Forum;
use App\Tag;
use App\TagGroup;
use Auth;
use App\User;
use App\ForumUser;
use Carbon\Carbon;

class ForumController extends Controller
{
    // 管理板块页面
    public function index()
    {
        // 判断是否板块管理员
        $is_forum_admin = Auth::user()->forums()->count() > 0;
        // 如果不是超级管理员，不让行
        if(!Auth::user()->is_super_admin && !$is_forum_admin)
            return "<script>alert('无权访问');history.go(-1);</script>";

        $forums = Forum::with(['tagGroups'])->get();
        $category_id = 2;
        foreach($forums as $forum){
            $forum['notJoinYetUsersId'] = array_diff(array_column(User::all()->toArray(), 'id'), array_column($forum->administrators->toArray(), 'id'));
        }

        return view('admin_forums')->with('forums', $forums)
                                   ->with('user', Auth::user())
                                   ->with('is_forum_admin', $is_forum_admin)
                                   ->with('category_id', $category_id);
    }

    // 存储板块
    public function store(Request $request)
    {
        Forum::create($request->all());
        return redirect()->back();
    }

    // 更新板块
    public function update(Request $request)
    {
        $forum = Forum::find($request->forum_id);
        $forum->name = $request->name;
        $forum->description = $request->description;
        $forum->save();
        return redirect()->back();
    }

    // 展示板块帖子
    public function show(Request $request, Forum $forum)
    {
        $forum = Forum::findOrFail($forum->id);
        $tagGroups = $forum->tagGroups;
        $tag_ids = array();
        // 如果没有标签值传来，创建新数组
        if(empty($request->tagids)){
            for($i=0; $i<count($tagGroups); $i++){
                array_push($tag_ids, 0);
            }
        }else{
            $tag_ids = explode('_', $request->tagids);
            // 如果标签数不及标签组数，如标签搜索事件
            if(count($tag_ids) != count($tagGroups)){
                $tag_ids = array();
                $tag = Tag::find($request->tagids);
                // 将标签归队于标签组所在的位置，其他位置为0
                foreach($tagGroups as $tagGroup){
                    if($tag->tag_group_id == $tagGroup->id)
                        array_push($tag_ids, $request->tagids);
                    else
                        array_push($tag_ids, 0);
                }
            }
        }

        $type = $request->type;
        $category_id = 0;
        $user_id = 0;
        if(empty($type)){
            // 查找标签
            $threads = $forum->threads()->where('is_filed', 0)->with(['tags']);
        } else {
            switch($type){
                // 获取精华帖子
                case 'good':
                    $threads = $forum->threads()->where('is_good', 1)->with(['tags']);
                    $category_id = 1;
                    break;
                // 获取归档帖子
                case 'filed':
                    $threads = $forum->threads()->where('is_filed', 1)->with(['tags']);
                    $category_id = 2;
                    break; 
                // 获取用户帖子
                case "user":
                    $threads = $forum->threads()->where('user_id', $request->user_id);
                    $category_id = 3;
                    $user_id = $request->user_id;
                break;
            }
        }

        // 根据标签寻找帖子
        foreach($tag_ids as $tag_id){
            if($tag_id != 0){
                $threads = $threads->whereHas('tags' , function($query) use ($tag_id){
                    $query->where('identity', '=', $tag_id);
                });
            }
        }
        $threads = $threads->orderBy('is_top', 'desc')->orderBy('created_at', 'desc')->paginate(15);
        // 获取发表过帖子的用户
        $forum_users = User::has('threads')->get();

        $forum_threads_count = $forum->threads()->count();
        $forum_today_threads = $forum->threads()->where('created_at', '>', Carbon::today())->count();

        return view('index')->with('threads', $threads)
                            ->with('forum_id', $forum->id)
                            ->with('forum', $forum)
                            ->with('forum_users', $forum_users)
                            ->with('tag_ids', $tag_ids)
                            ->with('category_id', $category_id)
                            ->with('user_id', $user_id)
                            ->with('forum_threads_count', $forum_threads_count)
                            ->with('forum_today_threads', $forum_today_threads);
    }

    public function addAdmin(Request $request)
    {
        $forum_id = $request->forum_id;
        $add_users = $request->add_users;
        $del_users = $request->del_users;
        // 添加用户
        if(!empty($add_users)){
            foreach($add_users as $user){
                $forumUser = new ForumUser();
                $forumUser->forum_id = $forum_id;
                $forumUser->user_id = $user;
                $forumUser->save();
            }
        }
        // 删除用户
        $this->delAdmin($forum_id, $del_users);
        return redirect()->back();
    }

    public function delAdmin($forum_id, $del_users)
    {
        if(!empty($del_users)){
            foreach($del_users as $user){
                ForumUser::where('forum_id', $forum_id)->where('user_id', $user)->delete();
            }
        }
    }

    public function destroy(Request $request)
    {
        Forum::destroy($request->forums);
        return redirect()->back();
    }
}
