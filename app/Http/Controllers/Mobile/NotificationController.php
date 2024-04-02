<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Services\ResponseController;
use Illuminate\Http\Request;

class NotificationController extends ResponseController
{
    public function list(Request $request)
    {
        $user = accessToken()->getMe();
        $user_id = $user->id;
        $lang = app()->getLocale();

        $limit      = $request->input('limit', 10);
        $page       = $request->input('page', 1);

        $query = Notification::query();
        $query->whereIn('user_id', [$user_id, 0]);

        $results = $query->orderBy('id', 'desc')
            ->offset(($page - 1) * $limit)
            ->limit($limit)
            ->get();

        $data = [];

        foreach ($results as $result) {
            $data[] = [
              'id' => $result->id,
              'title' => $result->{'title_' . $lang},
              'body' => $result->{'body_' . $lang},
              'type' => $result->type,
              'data' => is_null($result->link) ? $result->route : $result->link,
              'created_at' => $result->created_at
            ];
        }

        return self::successResponse($data);
    }
}
