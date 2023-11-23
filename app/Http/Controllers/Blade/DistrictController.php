<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Region;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function index()
    {
        abort_if_forbidden('district.show');
        $items = District::with('region')->get()->all();
        return view('pages.district.index',compact('items'));
    }

    // add permission page
    public function add()
    {
        abort_if_forbidden('district.add');
        $regions = Region::all();
        return view('pages.district.add', compact('regions'));
    }

    //create permission
    public function create(Request $request)
    {
        abort_if_forbidden('district.add');
        District::create($request->all());
        return redirect()->route('districtIndex');
    }

    // edit page
    public function edit($id)
    {
        abort_if_forbidden('district.edit');
        $item = District::where('id','=', $id)->get()->first();
        $regions = Region::all();
        return view('pages.district.edit',compact('item','regions'));
    }

    // update data
    public function update(Request $request,$id)
    {
        abort_if_forbidden('district.edit');
        $item = District::where('id','=', $id)->get()->first();
        $item->fill($request->all());
        $item->save();
        return redirect()->route('districtIndex');
    }

    // delete permission
    public function destroy($id)
    {
        abort_if_forbidden('item.delete');
        $item = District::where('id','=', $id)->get()->first();
        $item->delete();
        return redirect()->back();
    }
}
