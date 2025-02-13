<?php

namespace App\Http\Controllers;

use App\Models\Movility;
use Illuminate\Http\Request;

class MovilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $movilities = Movility::all();
        return view('admin.movility', compact('movilities'));
    }


    public function indexApi(){
        $movilities = Movility::all();
        return response()->json($movilities);
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
        //
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
