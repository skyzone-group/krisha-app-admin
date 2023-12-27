<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Key;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;


class KeyController extends Controller
{
    public function index()
    {
        abort_if_forbidden('key.show');
        $items = Key::all();
        return view('pages.key.index',compact('items'));
    }

    // add permission page
    public function add()
    {
        abort_if_forbidden('key.add');
        $elements = Category::all();
        return view('pages.key.add', compact('elements'));
    }

    //create permission
    public function create(Request $request)
    {
        abort_if_forbidden('key.add');
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'category_key' => 'required',
            'key' => [
                'required',
                Rule::unique('keys')->where(function ($query) use ($request) {
                    return $query->where('category_key', $request->input('category_key'));
                }),
            ],
            'type' => 'required',
        ]);

        // If validation fails, redirect back with errors and input
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Key::create($request->all());
        return redirect()->route('keyIndex');
    }

    // edit page
    public function edit($id)
    {
        abort_if_forbidden('key.edit');
        $item = Key::where('id','=', $id)->get()->first();
        $elements = Category::all();
        return view('pages.key.edit',compact('item', 'elements'));
    }

    // update data
    public function update(Request $request,$id)
    {
        abort_if_forbidden('key.update');

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'category_key' => 'required',
            'key' => [
                'required',
                Rule::unique('keys')->ignore($id)->where(function ($query) use ($request) {
                    return $query->where('category_key', $request->input('category_key'));
                }),
            ],
            'type' => 'required',
        ]);

        // If validation fails, redirect back with errors and input
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // If validation passes, update the Key
        $item = Key::find($id);
        $item->update($request->all());
        return redirect()->route('keyIndex');
    }

    // delete permission
    public function destroy($id)
    {
        abort_if_forbidden('key.delete');
        Key::destroy($id);
        return redirect()->back();
    }
}
