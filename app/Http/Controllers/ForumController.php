<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Forum;
use App\Tag;
use App\TagGroup;

class ForumController extends Controller
{
    // 管理板块页面
    public function index()
    {
        $forums = Forum::with(['tagGroups'])->get();
        return view('admin_forums')->with('forums', $forums);
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
        // 查找标签
        $threads = $forum->threads()->with(['tags']);
        foreach($tag_ids as $tag_id){
            if($tag_id != 0){
                $threads = $threads->whereHas('tags' , function($query) use ($tag_id){
                    $query->where('identity', '=', $tag_id);
                });
            }
        }
        $threads = $threads->orderBy('created_at', 'desc')->paginate(10);

        return view('index')->with('threads', $threads)
                            ->with('forum_id', $forum->id)
                            ->with('forum', $forum)
                            ->with('tag_ids', $tag_ids);
    }
}
