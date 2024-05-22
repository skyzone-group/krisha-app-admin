<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\StoryCategory;
use App\Models\ViewedStory;
use App\Services\ResponseController;
use Illuminate\Http\Request;

class StoryCategoryController extends ResponseController
{
    public function list(Request $request)
    {
        $lang = app()->getLocale();
        $items = StoryCategory::query();
        $user = accessToken()->getMe();
        $user_id = $user->id;

        //order by position if position is the same sort by id
        $items = $items->with('items')->orderBy('position')->orderBy('id')->get();

        $data = [];
        //get all viewed stories ids and check it with story item id
        $viewed_stories = ViewedStory::where('user_id', $user_id)->pluck('story_item_id')->toArray();
        foreach ($items as $item) {
            $subitems = [];
            $stories_count = 0;
            $unread_count = 0;
            foreach ($item->items as $subitem) {
                //check if the story item is viewed or not
                $stories_count++;
                if(!in_array($subitem->id, $viewed_stories))
                    $unread_count++;

                $action_type = 'none';
                $action_data = null;
                if (!is_null($subitem->estate_id) && $subitem->estate_id > 0) {
                    $action_type = 'estate_detail';
                    $action_data = $subitem->estate_id;
                }
                if (!is_null($subitem->link)) {
                    $action_type = 'link';
                    $action_data = $subitem->link;
                }

                $subitems[] = [
                    'id' => $subitem->id,
                    'type' => in_array(strtoupper($subitem->file_type), ['MP4', 'MOV', 'AVI']) ? 'video' : 'image',
                    'source' => $subitem->file,
                    'action' => $action_type == 'none' ? null : [
                        'title' => $subitem->{'title_' . $lang},
                        'subtitle' => $subitem->{'subtitle_' . $lang},
                        'type' => $action_type,
                        'data' => $action_data
                    ]
                ];


            }

            $data[] = [
                'id' => $item->id,
                'title' => $item->{'title_' . $lang},
                'image' => $item->photo,
                'stories_count' => $stories_count,
                'unread_count' => $unread_count,
                'items' => $subitems
            ];
        }
        return self::successResponse($data);
    }
}
