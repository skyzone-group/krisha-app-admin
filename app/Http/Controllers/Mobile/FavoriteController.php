<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Services\ResponseController;
use Illuminate\Http\Request;

class FavoriteController extends ResponseController
{
    public function list(Request $request)
    {
        $v = $this->validate($request->all(), [
            'type' => 'required'
        ]);

        if ($v !== true) return $v;

        $user       = accessToken()->getMe();
        $user_id    = $user->id;
        $limit      = $request->input('limit', 10);
        $page       = $request->input('page', 1);


        $favorites = Favorite::where('user_id', $user_id)
            ->where('type', $request->type)
            ->offset(($page - 1) * $limit)
            ->limit($limit)
            ->get();

        $data = [];
        foreach ($favorites as $favorite) {
            if($favorite->type == 'search') {
                $data[] = [
                    'id' => $favorite->id,
                    'type' => $favorite->type,
                    'title' => $favorite->title,
                    'subtitle' => $favorite->subtitle,
                    'request' => json_decode($favorite->request),
                    'comment' => $favorite->comment,
                    'created_at' => $favorite->created_at
                ];
            }
            else {
                $data[] = [
                    'id' => $favorite->id,
                    'object_id' => $favorite->object_id,
                    'type' => $favorite->type,
                    'comment' => $favorite->comment,
                    'created_at' => $favorite->created_at
                ];
            }
        }

        return self::successResponse($data);
    }

    public function create(Request $request)
    {
        $v = $this->validate($request->all(), [
            'type' => 'required',
            'object_id' => 'required_if:type,estate,jk',
            'request' => 'required_if:type,search'
        ]);

        if ($v !== true) return $v;

        $user       = accessToken()->getMe();
        $search     = $request->input('request', null);

        $favorite = Favorite::create([
           'user_id'    => $user->id,
           'object_id'  => $request->input('object_id', 0),
           'type'       => $request->type,
           'request'    => is_null($search) ? null : json_encode($search),
           'comment'    => $request->input('comment', null),
        ]);


        if ($favorite->type == 'search') {
            $favorite->title = 'Поиск';
            $favorite->subtitle = 'Поиск subtitle';
            $favorite->save();
        }

        return self::successResponse($favorite->id);
    }

    public function update(Request $request)
    {
        $v = $this->validate($request->all(), [
            'id' => 'required',
            'type' => 'required',
            'object_id' => 'required_if:type,estate,jk',
            'request' => 'required_if:type,search'
        ]);

        if ($v !== true) return $v;

        $user       = accessToken()->getMe();
        $search     = $request->input('request', null);

        $favorite = Favorite::find($request->input('id'));

        $favorite->user_id    = $user->id;
        $favorite->object_id  = $request->input('object_id', 0);
        $favorite->type       = $request->type;
        $favorite->request    = is_null($search) ? null : json_encode($search);
        $favorite->comment    = $request->input('comment', null);
        $favorite->title      = $request->input('title', $favorite->title);
        $favorite->subtitle   = $request->input('title', $favorite->subtitle);
        $favorite->save();

        return self::successResponse($favorite->id);
    }

    public function delete(Request $request)
    {
        $v = $this->validate($request->all(), [
            'id' => 'required'
        ]);

        if ($v !== true) return $v;

        $favorite = Favorite::find($request->input('id'));
        if ($favorite) $favorite->delete();

        return self::successResponse([]);
    }


}
