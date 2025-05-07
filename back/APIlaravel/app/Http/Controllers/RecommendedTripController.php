<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RecommendedTrip;

class RecommendedTripController extends Controller
{
    public function highlighted()
    {
        $trips = RecommendedTrip::inRandomOrder()->take(6)->get();
        return response()->json($trips);
    }
}
