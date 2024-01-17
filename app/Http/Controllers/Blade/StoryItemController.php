<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use App\Models\StoryCategory;
use App\Models\StoryItem;
use Illuminate\Http\Request;

class StoryItemController extends Controller
{
    public function index()
    {
        abort_if_forbidden('story-item.show');
        $items = StoryItem::with('story_category')->get();
        return view('pages.story-item.index',compact('items'));
    }

    // add permission page
    public function add()
    {
        abort_if_forbidden('story-item.add');
        $storyCategories = StoryCategory::all();
        return view('pages.story-item.add', compact('storyCategories'));
    }

    //create permission
    public function create(Request $request)
    {
        abort_if_forbidden('story-item.add');
        $item = StoryItem::create($request->all());

        if ($request->hasFile('file')) {
            $file = $request->file;
            $name = (microtime(true) * 10000) . '.' . $file->extension();
            $item->file = $name;

            $item->file_type = $file->extension();

            $file->move($item->public_path(), $name);
            $item->save();
        }

        return redirect()->route('story-itemIndex');
    }

    // edit page
    public function edit($id)
    {
        abort_if_forbidden('story-item.edit');
        $item = StoryItem::where('id','=', $id)->get()->first();
        $storyCategories = StoryCategory::all();
        return view('pages.story-item.edit',compact('item','storyCategories'));
    }

    // update data
    public function update(Request $request,$id)
    {
        abort_if_forbidden('story-item.edit');
        $item = StoryItem::where('id','=', $id)->get()->first();
        $oldfile = $item->file;
        $item->fill($request->all());
        if ($request->hasFile('file')) {
            deleteFile($oldfile);
            $file = $request->file;
            $name = (microtime(true) * 10000) . '.' . $file->extension();
            $item->file = $name;
            $item->file_type = $file->extension();
            $file->move($item->public_path(), $name);
        }

        $item->save();
        return redirect()->route('story-itemIndex');
    }

    // delete permission
    public function destroy($id)
    {
        abort_if_forbidden('item.delete');
        $item = StoryItem::where('id','=', $id)->get()->first();
        $item->remove();
        return redirect()->back();
    }
}
