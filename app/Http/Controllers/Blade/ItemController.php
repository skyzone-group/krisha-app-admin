<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function index()
    {
        abort_if_forbidden('item.show');
        $items = Item::all();
        return view('pages.item.index',compact('items'));
    }

    // add permission page
    public function add()
    {
        abort_if_forbidden('item.add');
        return view('pages.item.add');
    }

    //create permission
    public function create(Request $request)
    {
        abort_if_forbidden('item.add');
        Item::create($request->all());
        return redirect()->route('itemIndex');
    }

    // edit page
    public function edit($id)
    {
        abort_if_forbidden('item.edit');
        $item = Item::where('id','=', $id)->get()->first();
        return view('pages.item.edit',compact('item'));
    }

    // update data
    public function update(Request $request,$id)
    {
        abort_if_forbidden('item.edit');
        $item = Item::where('id','=', $id)->get()->first();
        $item->fill($request->all());
        $item->save();
        return redirect()->route('itemIndex');
    }

    // delete permission
    public function destroy($id)
    {
        abort_if_forbidden('item.delete');
        Item::destroy($id);
        return redirect()->back();
    }
}
