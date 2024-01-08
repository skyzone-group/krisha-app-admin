<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use App\Models\Key;
use App\Models\KeyItem;
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
        $items = Item::all();
        return view('pages.key.add', compact('elements', 'items'));
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
            'items' => 'required|array',
            'items.*' => 'required|integer', // Adjusted rule for integers
        ]);

        // If validation fails, redirect back with errors and input
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $result = Key::create($request->all());

        $data = [];

        if($request->has('items'))
        {
            foreach ($request->items as $item):
                $data[] = [
                    'key_id'          => $result->id,
                    'item_id'         => $item,
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ];
            endforeach;
        }

        if(sizeof($data))
            KeyItem::insert($data);

        return redirect()->route('keyIndex');
    }

    // edit page
    public function edit($id)
    {
        abort_if_forbidden('key.edit');
        $item = Key::with(['items' => function($query){
                            return $query->with('itemname');
                        }])
                    ->where('id','=', $id)
                    ->get()
                    ->first();
        $elements = Category::all();
        return view('pages.key.edit',compact('item', 'elements'));
    }

    // update data
    public function update(Request $request,$id)
    {
        dd($request);
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
