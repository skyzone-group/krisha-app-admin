<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\District;
use App\Models\Quarter;
use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function index()
    {
        abort_if_forbidden('region.show');
        $items = Region::all();
        return view('pages.region.index',compact('items'));
    }

    // add permission page
    public function add()
    {
        abort_if_forbidden('region.add');
        $countries = Country::all();
        return view('pages.region.add', compact('countries'));
    }

    //create permission
    public function create(Request $request)
    {
        abort_if_forbidden('region.add');
        Region::create($request->all());
        return redirect()->route('regionIndex');
    }

    // edit page
    public function edit($id)
    {
        abort_if_forbidden('region.edit');
        $item = Region::where('id','=', $id)->get()->first();
        $countries = Country::all();
        return view('pages.region.edit',compact('item', 'countries'));
    }

    // update data
    public function update(Request $request,$id)
    {
        abort_if_forbidden('region.edit');
        $item = Region::where('id','=', $id)->get()->first();
        $item->fill($request->all());
        $item->save();
        return redirect()->route('regionIndex');
    }

    // delete permission
    public function destroy($id)
    {
        abort_if_forbidden('item.delete');
        $item = Region::where('id','=', $id)->get()->first();
        $item->delete();

        $districtIds = District::where('region_id', $id)->pluck('id')->all();
        District::where('region_id', $id)->delete();
        if(!is_null($districtIds)) Quarter::whereIn('district_id', $districtIds)->delete();

        return redirect()->back();
    }
}
