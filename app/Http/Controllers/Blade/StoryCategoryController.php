<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StoryCategory;

class StoryCategoryController extends Controller
{
    public function index()
    {
        abort_if_forbidden('story-category.show');
        $items = StoryCategory::orderBy('position')->get()->all();
        return view('pages.story-category.index',compact('items'));
    }

    public function sort(Request $request)
    {
        if ($request->has('categories')) {
            $sortedData = $request->input('categories');
            $order = 1;

            foreach ($sortedData as $sortedCategory) {
                $categoryId = $sortedCategory['categoryId'];
                $category = StoryCategory::find($categoryId);
                $category->position = $order;
                $category->save();
                $order++;
            }

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

    // add permission page
    public function add()
    {
        abort_if_forbidden('story-category.add');
        return view('pages.story-category.add');
    }

    //create permission
    public function create(Request $request)
    {
        abort_if_forbidden('story-category.add');
        $item = StoryCategory::create($request->all());

        if ($request->hasFile('photo')) {
            $file = $request->photo;
            $name = (microtime(true) * 10000) . '.' . $file->extension();
            $item->photo = $name;
            $file->move($item->public_path(), $name);
            $item->save();
        }

        return redirect()->route('story-categoryIndex');
    }

    // edit page
    public function edit($id)
    {
        abort_if_forbidden('story-category.edit');
        $item = StoryCategory::where('id','=', $id)->get()->first();
        return view('pages.story-category.edit',compact('item'));
    }

    // update data
    public function update(Request $request,$id)
    {
        abort_if_forbidden('story-category.edit');
        $item = StoryCategory::where('id','=', $id)->get()->first();
        $oldfile = $item->photo;
        $item->fill($request->all());
        if ($request->hasFile('photo')) {
            deleteFile($oldfile);
            $file = $request->photo;
            $name = (microtime(true) * 10000) . '.' . $file->extension();
            $item->photo = $name;
            $file->move($item->public_path(), $name);
        }

        $item->save();
        return redirect()->route('story-categoryIndex');
    }

    // delete permission
    public function destroy($id)
    {
        abort_if_forbidden('item.delete');
        $item = StoryCategory::where('id','=', $id)->get()->first();
        $item->remove();
        return redirect()->back();
    }
}
