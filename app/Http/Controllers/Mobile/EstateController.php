<?php

namespace App\Http\Controllers\Mobile;

use App\Services\ResponseController;
use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\Estate;

class EstateController extends ResponseController
{
    //


    public function create(Request $request)
    {
        $user = accessToken()->getMe();

        $v = $this->validate($request->all(),[
            'category_type' => 'required',
            'price' => 'required',
            'region_id' => 'required',
            'district_id' => 'required',
            'currency' => 'required',
            'transaction_type' => 'required'
        ]);

        if ($v !== true) return $v;
        //array_merge($request->all(), ['user_id' => $user->id])
        $item = Estate::create([
            'user_id' => $user->id,
            'category_type' => $request->category_type,
            'room_count' => $request->room_count ?? 0,
            'floor' => $request->floor ?? 0,
            'floor_count' => $request->floor_count ?? 0,
            'home_number' => $request->home_number ?? 0,
            'price' => $request->price,
            'price_type' => $request->price_type ?? 'all',
            'transaction_type' => $request->transaction_type,
            'comment' => $request->comment ?? null,
            'total_area' => $request->total_area ?? 0,
            'kitchen_area' => $request->kitchen_area ?? 0,
            'land_area' => $request->land_area ?? 0,
            'land_area_type' => $request->land_area_type ?? 0,
            'latitude' => $request->latitude ?? null,
            'longitude' => $request->longitude ?? null,
            'is_owner' => $user->is_owner ?? false,
            'is_new' => $user->is_new ?? false,
            'is_barter' => $user->is_barter ?? false,
            'is_negotiable' => $user->is_negotiable ?? false,
            'is_home_number_hidden' => $user->is_home_number_hidden ?? false,
            'region_id' => $request->region_id,
            'district_id' => $request->district_id,
            'quarter_id' => $request->quarter_id ?? 0,
            'underground_id' => $request->underground_id ?? 0,
            'build_year' => $request->build_year ?? 0,
            'video' => $request->video ?? null,
            'ceiling_height' => $request->ceiling_height ?? 0,
            'bathroom_count' => $request->bathroom_count ?? 0,
            'currency' => $request->currency
        ]);
        $estate_id = $item->id;

        #Uploading image to server
        $imagesData = [];
        $images = $request->get('images') ?? [];
        for($i = 0; $i < sizeof($images); $i++){
            if(!is_null($images[$i]))
            {
                $imagesData[] = [
                    'name'                     => $images[$i],
                    'estate_id'                => $estate_id ?? 0,
                    'created_at'               => now(),
                    'updated_at'               => now(),
                ];
            }

        }
        #end of uploading image

        if(sizeof($imagesData)) Image::insert($imagesData);

        return self::successResponse($estate_id);
    }
}
