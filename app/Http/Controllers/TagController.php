<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use App\TagGroup;
use Auth;

class TagController extends Controller
{

    public function index()
    {
        $is_forum_admin = Auth::user()->forums()->count() > 0;
        // 如果不是超级管理员，不让行
        if(!Auth::user()->is_super_admin && !$is_forum_admin)
            return "<script>alert('无权访问');history.go(-1);</script>";
            
        $tags = Tag::orderBy('identity', 'asc')->get();
        $category_id = 3;
        return view('admin_tags')->with('tags', $tags)->with('user', Auth::user())->with('is_forum_admin', $is_forum_admin)->with('category_id', $category_id);
    }

    // 更新标签组名称及标签
    public function store(Request $request)
    {
        // 更新标签组名称
        $forum_id = $request->forum_id;
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
                $tag->forum_id = $forum_id;
                $tag->tag_group_id = $group_id;
                $tag->identity = $tag_identity;
                $tag->name = $tag_name;
                $tag->color = $tag_color;
                $tag->save();
            }
        }
        return redirect()->back();
    }

    public function destroy($id){
        Tag::destroy($id);
    }
}
