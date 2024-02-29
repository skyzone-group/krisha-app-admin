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

        $limit      = $request->input('limit', 10);
        $page       = $request->input('page', 1);
        $sort       = $request->input('sort', 'id');
        $direction  = $request->input('direction', 'desc');

        $query = Estate::query();
        $query->where('user_id',$user_id);

        // Define an array of searchable fields
        $searchableFields = [
            'region_id', 'district_id', 'quarter_id', 'underground_id', 'category_type', 'transaction_type',
            'price', 'currency', 'room_count', 'floor', 'floor_count', 'total_area', 'kitchen_area',
            'land_area', 'land_area_type', 'build_year', 'ceiling_height', 'bathroom_count', 'is_owner',
            'is_new', 'is_barter', 'is_negotiable', 'is_home_number_hidden', 'price_type',

            'price_from',
            'room_count_from',
            'total_area_from',
            'kitchen_area_from',
            'build_year_from',
            'ceiling_height_from',
            'land_area_from',

            'price_to',
            'room_count_to',
            'total_area_to',
            'kitchen_area_to',
            'build_year_to',
            'ceiling_height_to',
            'land_area_to'
        ];

        // Loop through the searchable fields and apply filters if they exist in the request
        foreach ($searchableFields as $field) {
            if ($value = $request->input($field)) {
                // If the field ends with "_from", use greater than or equal to comparison
                if (str_contains($field, '_from')) {
                    $query->where(str_replace('_from', '', $field), '>=', $value);
                }
                // If the field ends with "_to", use less than or equal to comparison
                elseif (str_contains($field, '_to')) {
                    $query->where(str_replace('_to', '', $field), '<=', $value);
                } else {
                    $query->where($field, $value);
                }
            }
        }

        $query = $query->with([
                        'images:name', // Only retrieve the 'name' column of images
                        'region',
                        'district',
                        'quarter',
                        'underground',
                    ]);

        $total = $query->count();

        // Retrieve results with sorting, pagination, and limit
        $results = $query->orderBy($sort, $direction)
            ->offset(($page - 1) * $limit)
            ->limit($limit)
            ->get();

        // Extract IDs from results for efficient database query
        $estateIds = $results->pluck('id');

        // Retrieve key items for all estate IDs
        $keyItems = KeyItemValue::whereIn('estate_id', $estateIds)
            ->with('key', 'item')
            ->get();

        // Group key items by estate ID
        $keyData = [];
        foreach ($keyItems as $item) {
            $keyData[$item->estate_id][$item->key_id]['key'] = $item->key;
            $keyData[$item->estate_id][$item->key_id]['items'][] = $item->item;
        }

        // Prepare extra data for estates
        $extraData = [];
        foreach ($keyData as $estateId => $items) {
            $extraData[$estateId] = array_values($items);
        }

        // Prepare estates with optimized data structure
        $estates = [];
        foreach ($results as $item) {
            $estate = $item->toArray();
            $estate['images'] = $item->images->pluck('name')->toArray(); // Convert images to an array of names
            $estate['keys'] = $extraData[$item->id] ?? []; // Retrieve extra data for the estate
            $estates[] = $estate;
        }
        // Prepare response data
        $data = [
            'count' => $total, // Assuming $total is defined elsewhere
            'estates' => $estates,
        ];

        // Return success response
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
