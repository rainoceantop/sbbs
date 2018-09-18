<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Forum;
use App\TagGroup;

class ForumController extends Controller
{
    public function index()
    {
        $forums = Forum::all();
        foreach($forums as $forum){
            $forum['tagGroups'] = $forum->tagGroups;
        }
        return view('admin_forums')->with('forums', $forums);
    }

    public function store(Request $request)
    {
        Forum::create($request->all());
        return redirect()->back();
    }

}
