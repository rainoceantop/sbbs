<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use App\TagGroup;

class TagController extends Controller
{
    public function store(Request $request)
    {
        // 更新标签组名称
        $group_id = $request->group_id;
        $tagGroup = TagGroup::find($group_id);
        $group_name = $request->tagGroupName;
        $tagGroup->name = $group_name;
        $tagGroup->save();

        // 更新标签组标签
        $old_tags = $tagGroup->tags->toArray();
        // 将原来的所有标签删除
        if(!empty($old_tags)){
            $tags_id = array_column($old_tags, 'id');
            $this->destroy($tags_id);
        }
        // 处理新标签
        $new_tags = explode(' ', $request->tagNames);
        foreach($new_tags as $new_tag){
            $new_tag = explode(',', $new_tag);
            $tag_name = trim($new_tag[0]);
            $tag_color = trim($new_tag[1]);
            $tag = new Tag();
            $tag->tag_group_id = $group_id;
            $tag->name = $tag_name;
            $tag->color = $tag_color;
            $tag->save();
        }
        return redirect()->back();
    }


    public function destroy($id){
        Tag::destroy($id);
    }
}
