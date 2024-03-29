<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Quarter;
use App\Models\Region;
use App\Services\ResponseController;
use Illuminate\Http\Request;

class ConstantsController extends ResponseController
{
    public function list()
    {
        $regions = Region::with('districts', 'districts.quarters')->get()->all();
        $data['regions'] = $regions;
        $data['default_region'] = Region::where('name_uz', 'like', '%shkent%')->first();

        return self::successResponse($data);
    }

    public function search(Request $request)
    {
//        $v = $this->validate($request->all(),[
//            'keyword' => 'required'
//        ]);
//        if ($v !== true) return $v;

        $lang = app()->getLocale();
        $keyword = $request->keyword ?? null;
        $id = $request->id ?? null;
        $type = $request->type ?? null;


        if (is_null($keyword))
        {
            $regions = Region::with('country')->get();
            $districts = District::with('region')->get();
            $quarters = Quarter::with('district')->get();
        }
        else {
            $regions = Region::where('name_' . $lang, 'like', '%' . $keyword . '%')->with('country')->get();
            $districts = District::where('name_' . $lang, 'like', '%' . $keyword . '%')->with('region')->get();
            $quarters = Quarter::where('name_' . $lang, 'like', '%' . $keyword . '%')->with('district')->get();
        }

        $data = [];
        if ($type == null) {
            foreach ($regions as $region) {
                $data[] = [
                    'id' => $region->id,
                    'title' => $region->{'name_' . $lang},
                    'subtitle' => $region->country->{'name_' . $lang},
                    'type' => 'region'
                ];
            }
        }

        if ($type == 'region' || ($type == null && !is_null($keyword))) {
            foreach ($districts as $district) {
                if (is_null($id)) {
                    $data[] = [
                        'id' => $district->id,
                        'title' => $district->{'name_' . $lang},
                        'subtitle' => $district->region->{'name_' . $lang},
                        'type' => 'district'
                    ];
                } else if($id == $district->region->id) {
                    $data[] = [
                        'id' => $district->id,
                        'title' => $district->{'name_' . $lang},
                        'subtitle' => $district->region->{'name_' . $lang},
                        'type' => 'district'
                    ];
                }
            }
        }

        if ($type == 'district') {
            foreach ($quarters as $quarter) {
                if (is_null($id)) {
                    $data[] = [
                        'id' => $quarter->id,
                        'title' => $quarter->{'name_' . $lang},
                        'subtitle' => $quarter->district->{'name_' . $lang},
                        'type' => 'quarter'
                    ];
                } else if($id == $quarter->district->id) {
                    $data[] = [
                        'id' => $quarter->id,
                        'title' => $quarter->{'name_' . $lang},
                        'subtitle' => $quarter->district->{'name_' . $lang},
                        'type' => 'quarter'
                    ];
                }

            }
        }

        return self::successResponse($data);
    }
}
