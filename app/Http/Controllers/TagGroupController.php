<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TagGroup;

class TagGroupController extends Controller
{
    public function store(Request $request)
    {
        TagGroup::create($request->all());
        return redirect()->back();
    }

    public function destroy($id)
    {
        $tagGroup = TagGroup::findOrFail($id);
        $tagGroup->delete();
        echo TRUE;
    }
}
