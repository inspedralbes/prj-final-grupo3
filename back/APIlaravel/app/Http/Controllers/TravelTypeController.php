<?php

namespace App\Http\Controllers;

use App\Models\Travel;
use App\Models\TravelType;
use Illuminate\Http\Request;

class TravelTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $travelTypes = TravelType::all();
        return view ('admin.travel-type', compact('travelTypes'));
    }


    public function typesApi(){
        $travelTypes = TravelType::all();
        return response()->json($travelTypes);
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
            "type" => "required|string",
        ]);

        // Guardar en la base de datos
        TravelType::create([
            'type' => $request->input('type'),
        ]);
        return redirect()->route('travel-types')->with('success', 'El tipus de viatge s\'ha afegit correctament.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
