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
        $v = $this->validate($request->all(),[
            'story_category_id' => 'required'
        ]);
        if ($v !== true) return $v;

        $story_category_id = $request->story_category_id;

        $items = StoryItem::query();
        $items = $items->where('story_category_id', $story_category_id);
        $items = $items->get();
        return self::successResponse($items);
    }

    public function view(Request $request)
    {
        $v = $this->validate($request->all(),[
            'story_item_id' => 'required'
        ]);
        if ($v !== true) return $v;

        $story_item_id = $request->story_item_id;

        //do all thing

        return self::successResponse([],"viewed");
    }

}
