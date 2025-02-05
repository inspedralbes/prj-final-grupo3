<?php

namespace App\Http\Controllers;

use App\Models\Travel;
use Illuminate\Http\Request;

class TravelsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $travels = Travel::with(['country', 'type', 'budget', 'movility', 'user'])->get();
        return view('admin.travels', compact('travels'));
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
        // Travel::create([
        //     'id_country' => $countryId,
        //     'id_user' => $userId,
        //     'id_type' => $typeId,
        //     'id_budget' => $budgetId,
        //     'id_movility' => $movilityId,
        //     'date_init' => '2025-02-01',
        //     'date_end' => '2025-02-05',
        //     'description' => 'Viaje a ejemplo',
        // ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $travel = Travel::findOrFail($id);
        // dd($user);
        return view('admin.travel-details', compact('travel'));
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
