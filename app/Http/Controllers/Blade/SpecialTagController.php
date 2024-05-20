<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SpecialTag;
use Illuminate\Http\Request;

class SpecialTagController extends Controller
{
    public function index()
    {
        abort_if_forbidden('special-tag.show');
        $items = SpecialTag::all();
        return view('pages.special-tag.index',compact('items'));
    }

    // add permission page
    public function add()
    {
        abort_if_forbidden('special-tag.add');
        $categories = Category::all();
        return view('pages.special-tag.add', compact('categories'));
    }

    //create permission
    public function create(Request $request)
    {
        abort_if_forbidden('special-tag.add');
        $item = SpecialTag::create($request->all());
        if ($request->hasFile('icon')) {
            $file = $request->icon;
            $name = (microtime(true) * 10000) . '.' . $file->extension();
            $item->icon = $name;
            $file->move($item->public_path(), $name);
            $item->save();
        }
        return redirect()->route('special-tagIndex');
    }

    // edit page
    public function edit($id)
    {
        abort_if_forbidden('special-tag.edit');
        $item = SpecialTag::where('id','=', $id)->get()->first();
        $categories = Category::all();
        return view('pages.special-tag.edit',compact('item', 'categories'));
    }

    // update data
    public function update(Request $request,$id)
    {
        abort_if_forbidden('special-tag.edit');
        $item = SpecialTag::where('id','=', $id)->get()->first();
        $oldfile = $item->icon;
        $item->fill($request->all());
        if ($request->hasFile('icon')) {
            deleteFile($oldfile);
            $file = $request->icon;
            $name = (microtime(true) * 10000) . '.' . $file->extension();
            $item->icon = $name;
            $file->move($item->public_path(), $name);
        }
        $item->save();
        return redirect()->route('special-tagIndex');
    }

    // delete permission
    public function destroy($id)
    {
        abort_if_forbidden('item.delete');
        $item = SpecialTag::where('id','=', $id)->get()->first();
        $item->remove();
        return redirect()->back();
    }
}
