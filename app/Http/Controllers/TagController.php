<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use App\TagGroup;

class TagController extends Controller
{

    // 更新标签组名称及标签
    public function store(Request $request)
    {
        // 更新标签组名称
        $group_id = $request->group_id;
        $tagGroup = TagGroup::find($group_id);
        $group_name = $request->tagGroupName;
        $tagGroup->name = $group_name;
        $tagGroup->save();

        // 处理标签
        $tags = explode(';', trim($request->tagNames));

        foreach($tags as $tag){
            if(!empty($tag)){
                $tag = explode(',', trim($tag));
                $tag_identity = trim($tag[0]);
                $tag_name = trim($tag[1]);
                $tag_color = trim($tag[2]);
                $tag = Tag::where('identity', '=', $tag_identity)->first();
                if(empty($tag))
                    $tag = new Tag();
                $tag->tag_group_id = $group_id;
                $tag->identity = $tag_identity;
                $tag->name = $tag_name;
                $tag->color = $tag_color;
                $tag->save();
            }
        }
        return redirect()->back();
    }

    // 获取标签帖子
    public function show(Tag $tag)
    {
        $threads = Tag::findOrFail($tag->identity)->threads()->with(['tags'])->orderBy('created_at', 'desc')->paginate(10);
        $forum_id = $tag->group->forum_id;
        return view('index')->with('threads', $threads)
                            ->with('forum_id', $forum_id);
    }

    public function destroy($id){
        Tag::destroy($id);
    }
}
