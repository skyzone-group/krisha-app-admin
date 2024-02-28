<?php

namespace App\Http\Controllers\Mobile;

use App\Services\ResponseController;
use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\Estate;
use App\Models\KeyItemValue;

class EstateController extends ResponseController
{
    //
    public function list(Request $request)
    {
        $user = accessToken()->getMe();
        $user_id = $user->id;

        $limit = $request->limit ?? 10;
        $page = $request->page ?? 1;

        $query = Estate::query();

        $region_id       = $request->region_id ?? null;
        $district_id     = $request->district_id ?? null;
        $quarter_id      = $request->quarter_id ?? null;
        $underground_id  = $request->underground_id ?? null;
        $category_type   = $request->category_type ?? null;
        $transaction_type = $request->transaction_type ?? null;
        $price_from      = $request->price_from ?? null;
        $price_to        = $request->price_to ?? null;
        $currency        = $request->currency ?? null;
        $room_count      = $request->room_count ?? null;
        $floor           = $request->floor ?? null;
        $floor_count     = $request->floor_count ?? null;
        $total_area_from = $request->total_area_from ?? null;
        $total_area_to   = $request->total_area_to ?? null;
        $kitchen_area_from = $request->kitchen_area_from ?? null;
        $kitchen_area_to = $request->kitchen_area_to ?? null;
        $land_area_from  = $request->land_area_from ?? null;
        $land_area_to    = $request->land_area_to ?? null;
        $land_area_type  = $request->land_area_type ?? null;
        $build_year_from = $request->build_year_from ?? null;
        $build_year_to   = $request->build_year_to ?? null;
        $ceiling_height_from = $request->ceiling_height_from ?? null;
        $ceiling_height_to = $request->ceiling_height_to ?? null;
        $bathroom_count  = $request->bathroom_count ?? null;
        $is_owner        = $request->is_owner ?? null;
        $is_new          = $request->is_new ?? null;
        $is_barter       = $request->is_barter ?? null;
        $is_negotiable   = $request->is_negotiable ?? null;
        $is_home_number_hidden = $request->is_home_number_hidden ?? null;
        $price_type      = $request->price_type ?? null;
        $sort            = $request->sort ?? 'id';
        $direction       = $request->direction ?? 'desc';

        $query->where('user_id',$user_id);

        if($region_id) $query->where('region_id',$region_id);
        if($district_id) $query->where('district_id',$district_id);
        if($quarter_id) $query->where('quarter_id',$quarter_id);
        if($underground_id) $query->where('underground_id',$underground_id);
        if($category_type) $query->where('category_type',$category_type);
        if($transaction_type) $query->where('transaction_type',$transaction_type);
        if($price_from) $query->where('price','>=',$price_from);
        if($price_to) $query->where('price','<=',$price_to);
        if($currency) $query->where('currency',$currency);
        if($room_count) $query->where('room_count',$room_count);
        if($floor) $query->where('floor',$floor);
        if($floor_count) $query->where('floor_count',$floor_count);
        if($total_area_from) $query->where('total_area','>=',$total_area_from);
        if($total_area_to) $query->where('total_area','<=',$total_area_to);
        if($kitchen_area_from) $query->where('kitchen_area','>=',$kitchen_area_from);
        if($kitchen_area_to) $query->where('kitchen_area','<=',$kitchen_area_to);
        if($land_area_from) $query->where('land_area','>=',$land_area_from);
        if($land_area_to) $query->where('land_area','<=',$land_area_to);
        if($land_area_type) $query->where('land_area_type',$land_area_type);
        if($build_year_from) $query->where('build_year','>=',$build_year_from);
        if($build_year_to) $query->where('build_year','<=',$build_year_to);
        if($ceiling_height_from) $query->where('ceiling_height','>=',$ceiling_height_from);
        if($ceiling_height_to) $query->where('ceiling_height','<=',$ceiling_height_to);
        if($bathroom_count) $query->where('bathroom_count',$bathroom_count);
        if($is_owner) $query->where('is_owner',$is_owner);
        if($is_new) $query->where('is_new',$is_new);
        if($is_barter) $query->where('is_barter',$is_barter);
        if($is_negotiable) $query->where('is_negotiable',$is_negotiable);
        if($is_home_number_hidden) $query->where('is_home_number_hidden',$is_home_number_hidden);
        if($price_type) $query->where('price_type',$price_type);

        $query = $query->with([
                            'images',
                            'region',
                            'district',
                            'quarter',
                            'underground',
                            'keys' => function($query){
                                $query->with('key','item');
                            }
                    ]);

        $total = $query->count();
        $results = $query->orderBy($sort,$direction)
                    ->limit($limit)
                    ->offset(($page-1)*$limit)
                    ->get();

        $data['count'] = $total;
        $estates = [];

        foreach ($results as $item):
            $images = [];
            if(!is_null($item->images))
            {
                foreach ($item->images as $image):
                    $images[] = $image->name;
                endforeach;
                unset($item->images);
                $item->images = $images;
            }
            $estates[] = $item;
        endforeach;
        $data['estates'] = $estates;
        return self::successResponse($data);

    }


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

        $key_item_values = $request->get('key_item_values') ?? [];
        $key_item_values_data = [];

        foreach($key_item_values as $key => $value) {
            foreach ($value as $item) {
                $key_item_values_data[] = [
                    'estate_id' => $estate_id,
                    'key_id' => $key,
                    'item_id' => $item,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        if(sizeof($key_item_values_data)) KeyItemValue::insert($key_item_values_data);
        if(sizeof($imagesData)) Image::insert($imagesData);

        return self::successResponse($estate_id);
    }
}
