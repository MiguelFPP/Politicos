<?php

namespace App\Http\Controllers;

use App\Models\Commune;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function getCommunes(){
        $communes = Commune::all();
        return response()->json($communes);
    }

    public function getQuarters($commune_id){
        $commune = Commune::find($commune_id);
        $quarters = $commune->quarters;
        return response()->json($quarters);
    }
}
