<?php

namespace App\Http\Controllers;

use App\Models\Commune;
use App\Models\Sidewalk;
use App\Models\Township;
use Exception;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function getQuarters($commune_id){
        $commune = Commune::find($commune_id);
        $quarters = $commune->quarters;
        return response()->json($quarters);
    }

    public function getSidewalks($sidewalk_id){
        $townships = Township::find($sidewalk_id);
        $sidewalks = $townships->sidewalks;
        return response()->json($sidewalks);
    }
}
