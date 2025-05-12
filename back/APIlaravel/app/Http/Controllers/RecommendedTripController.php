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

    public function show($id)
    {
        $trip = \App\Models\RecommendedTrip::find($id);

        if (!$trip) {
            return response()->json(['message' => 'Viatge no trobat'], 404);
        }

        return response()->json($trip);
    }

}
