<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Quarter;
use Illuminate\Http\Request;

class QuarterController extends Controller
{
    public function index()
    {
        abort_if_forbidden('quarter.show');
        $items = Quarter::with('district')->get()->all();
        return view('pages.quarter.index',compact('items'));
    }

    // add permission page
    public function add()
    {
        abort_if_forbidden('quarter.add');
        $districts = District::all();
        return view('pages.quarter.add', compact('districts'));
    }

    //create permission
    public function create(Request $request)
    {
        abort_if_forbidden('quarter.add');
        Quarter::create($request->all());
        return redirect()->route('quarterIndex');
    }

    // edit page
    public function edit($id)
    {
        abort_if_forbidden('quarter.edit');
        $item = Quarter::where('id','=', $id)->get()->first();
        $districts = District::all();
        return view('pages.quarter.edit',compact('item','districts'));
    }

    // update data
    public function update(Request $request,$id)
    {
        abort_if_forbidden('quarter.edit');
        $item = Quarter::where('id','=', $id)->get()->first();
        $item->fill($request->all());
        $item->save();
        return redirect()->route('quarterIndex');
    }

    // delete permission
    public function destroy($id)
    {
        abort_if_forbidden('item.delete');
        $item = Quarter::where('id','=', $id)->get()->first();
        $item->delete();
        return redirect()->back();
    }
}
