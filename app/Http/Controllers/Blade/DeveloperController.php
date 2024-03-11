<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use App\Models\Developer;
use Illuminate\Http\Request;

class DeveloperController extends Controller
{
    public function index()
    {
        abort_if_forbidden('developer.show');
        $items = Developer::all();
        return view('pages.developer.index',compact('items'));
    }

    // add permission page
    public function add()
    {
        abort_if_forbidden('developer.add');
        return view('pages.developer.add');
    }

    //create permission
    public function create(Request $request)
    {
        abort_if_forbidden('developer.add');
        Developer::create($request->all());
        return redirect()->route('developerIndex');
    }

    // edit page
    public function edit($id)
    {
        abort_if_forbidden('developer.edit');
        $item = Developer::where('id','=', $id)->get()->first();
        return view('pages.developer.edit',compact('item'));
    }

    // update data
    public function update(Request $request,$id)
    {
        abort_if_forbidden('developer.edit');
        $item = Developer::where('id','=', $id)->get()->first();
        $item->fill($request->all());
        $item->save();
        return redirect()->route('developerIndex');
    }

    // delete permission
    public function destroy($id)
    {
        abort_if_forbidden('developer.delete');
        Developer::destroy($id);
        return redirect()->back();
    }
}
