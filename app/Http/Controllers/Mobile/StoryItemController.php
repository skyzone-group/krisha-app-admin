<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\StoryItem;
use App\Models\ViewedStory;
use App\Services\ResponseController;
use Illuminate\Http\Request;

class StoryItemController extends ResponseController
{
    public function list(Request $request)
    {
        $lang = app()->getLocale();
        $v = $this->validate($request->all(),[
            'story_category_id' => 'required'
        ]);
        if ($v !== true) return $v;

        $story_category_id = $request->story_category_id;

        $items = StoryItem::query();
        $items = $items->where('story_category_id', $story_category_id);
        $items = $items->get();

        $data = [];
        foreach ($items as $item) {
            $action_type = 'none';
            $action_data = null;
            if (!is_null($item->estate_id) && $item->estate_id > 0) {
                $action_type = 'estate_detail';
                $action_data = $item->estate_id;
            }
            if (!is_null($item->link)) {
                $action_type = 'link';
                $action_data = $item->link;
            }

            $data[] = [
                'id' => $item->id,
                'type' => in_array(strtoupper($item->file_type), ['MP4', 'MOV', 'AVI']) ? 'video' : 'image',
                'source' => $item->file,
                'action' => $action_type == 'none' ? null : [
                    'title' => $item->{'title_' . $lang},
                    'subtitle' => $item->{'subtitle_' . $lang},
                    'type' => $action_type,
                    'data' => $action_data
                ]
            ];
        }

        return self::successResponse($data);
    }

    public function view(Request $request)
    {
        $v = $this->validate($request->all(),[
            'story_item_id' => 'required'
        ]);
        if ($v !== true) return $v;

        $story_item_id = $request->story_item_id;
        $user = accessToken()->getMe();
        $user_id = $user->id;
        //do all thing

        $res = ViewedStory::create([
            'story_item_id' => $story_item_id,
            'user_id' => $user_id
        ]);

        return self::successResponse([],"viewed");
    }

}
