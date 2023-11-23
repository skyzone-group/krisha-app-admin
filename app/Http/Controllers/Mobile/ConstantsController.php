<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Region;
use App\Services\ResponseController;
use Illuminate\Http\Request;

class ConstantsController extends ResponseController
{
    public function list()
    {
        $regions = Region::with('districts', 'districts.quarters')->get()->all();


        $data['regions'] = $regions;

        return self::successResponse($data);
    }
}
