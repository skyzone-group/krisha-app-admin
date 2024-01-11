<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Key;
use App\Services\ResponseController;
use Illuminate\Http\Request;

class KeyController extends ResponseController
{
    public function list(Request $request)
    {
        $items = Key::query();
        if($request->has('category_key') && strlen($request->category_key))
        {
            $items = $items->where('category_key', $request->category_key);
        }
        $items = $items->with('items')->get();
        return self::successResponse($items);
    }
}
