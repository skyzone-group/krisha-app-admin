<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\SpecialTag;
use App\Services\ResponseController;
use Illuminate\Http\Request;

class SpecialTagController extends ResponseController
{
    public function list(Request $request)
    {
        $items = SpecialTag::query();

        if($request->has('category_type') && strlen($request->category_type))
        {
            $items = $items->where('category_type', $request->category_type);
        }
        $items = $items->get()->all();
        return self::successResponse($items);
    }
}
