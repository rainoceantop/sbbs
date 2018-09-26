<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Forum;
use App\Tag;
use App\TagGroup;
use Auth;
use App\User;
use App\ForumUser;

class ForumController extends Controller
{
    // 管理板块页面
    public function index()
    {
        // 如果不是超级管理员，不让行
        if(!Auth::user()->is_super_admin)
            return "<script>alert('无权访问');history.go(-1);</script>";

        $forums = Forum::with(['tagGroups'])->get();
        foreach($forums as $forum){
            $forum['notJoinYetUsersId'] = array_diff(array_column(User::all()->toArray(), 'id'), array_column($forum->administrators->toArray(), 'id'));
        }
        return view('admin_forums')->with('forums', $forums)->with('user', Auth::user());
    }

    // 存储板块
    public function store(Request $request)
    {
        Forum::create($request->all());
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
        if(empty($type)){
            // 查找标签
            $threads = $forum->threads()->where('is_filed', 0)->with(['tags']);
        } else {
            switch($type){
                // 获取精华帖子
                case 'good':
                    $threads = $forum->threads()->where('is_filed', 0)->where('is_good', 1)->with(['tags']);
                    break;
                // 获取归档帖子
                case 'filed':
                    $threads = $forum->threads()->where('is_filed', 1)->with(['tags']);
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

        return view('index')->with('threads', $threads)
                            ->with('forum_id', $forum->id)
                            ->with('forum', $forum)
                            ->with('tag_ids', $tag_ids);
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
