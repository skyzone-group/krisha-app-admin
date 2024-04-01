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
        $lang = app()->getLocale();
        $items = StoryCategory::query();
//        $items = $items->with('items')->get();

        //order by position if position is the same sort by id
        $items = $items->orderBy('position')->orderBy('id')->get();
        $data = [];
        foreach ($items as $item) {
            $data[] = [
                'id' => $item->id,
                'title' => $item->{'title_' . $lang},
                'image' => $item->photo,
            ];
        }
        return self::successResponse($data);
    }
}
