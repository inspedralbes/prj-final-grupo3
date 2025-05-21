<?php

namespace App\Http\Controllers;

use App\Models\FavoriteTravel;
use Illuminate\Http\Request;

class FavoriteTravelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'travel_id' => 'required|exists:travels,id',
        ]);

        $favoriteTravel = FavoriteTravel::create([
            'user_id' => $request->id,
            'travel_id' => $request->travel_id,
        ]);

        return response()->json($favoriteTravel, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(FavoriteTravel $favoriteTravel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FavoriteTravel $favoriteTravel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FavoriteTravel $favoriteTravel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FavoriteTravel $favoriteTravel)
    {
        $favoriteTravel->delete();

        return response()->json(['message' => 'Favorite travel deleted successfully'], 200);
    }
}
