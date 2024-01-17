<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\StoryItem;
use App\Services\ResponseController;
use Illuminate\Http\Request;

class StoryItemController extends ResponseController
{
    public function list(Request $request)
    {
        $story_category_id = $request->story_category_id ?? null;
        if(!$story_category_id)
        {
            return self::errorResponse([
                'uz' => "story_category_id required",
                'ru' => "story_category_id required",
                'en' => "story_category_id required",
            ]);
        }

        $items = StoryItem::query();
        $items = $items->where('story_category_id', $story_category_id);
        $items = $items->get();
        return self::successResponse($items);
    }

    public function view(Request $request)
    {
        $story_item_id = $request->story_item_id ?? null;
        if(!$story_item_id)
        {
            return self::errorResponse([
                'uz' => "story_item_id required",
                'ru' => "story_item_id required",
                'en' => "story_item_id required",
            ]);
        }

        //do all thing

        return self::successResponse([],"viewed");
    }

}
