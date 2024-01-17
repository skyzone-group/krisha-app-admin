<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\StoryCategory;
use App\Services\ResponseController;
use Illuminate\Http\Request;

class StoryCategoryController extends ResponseController
{
    public function list(Request $request)
    {
        $items = StoryCategory::query();
        $items = $items->with('items')->get();
        return self::successResponse($items);
    }
}
