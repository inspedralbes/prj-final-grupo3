<?php

namespace App\Http\Controllers;

use App\Models\Travel;
use Illuminate\Http\Request;
use App\Models\Budget;

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
    public function storetravel(Request $request)
    {
        //validate
        $request->validate([
            'id_user' => 'required|exists:users,id',
            'id_country' => 'required|exists:countries,id',
            'id_type' => 'required|exists:type,id',
            // 'id_budget' => 'required|exists:budget,id',
            'id_budget_min' => 'required|numeric',
            'id_budget_max' => 'required|numeric',
            //'id_budget_final' => 'required|numeric',
            'id_movility' => 'required|exists:movilities,id',
            'date_init' => 'required|date',
            'date_end' => 'required|date|after_or_equal:date_init',
            'description' => 'required|string|max:1000',
        ]);

        //save in the budget
        $budget = Budget::create([
            'min_budget' => $request->input('id_budget_min'),
            'max_budget' => $request->input('id_budget_max'),
            //'final_price' => $request->input('id_budget_final'),
        ]);
        //

        Travel::create([
            'id_user' => $request->input('id_user'),
            'id_country' => $request->input('id_country'),
            'id_type' => $request->input('id_type'),
            'id_budget' => $budget->id,
            'id_movility' => $request->input('id_movility'),
            'date_init' => $request->input('date_init'),
            'date_end' => $request->input('date_end'),
            'description' => $request->input('description'),
        ]);
        //return response()->json(['message' => 'Travel created successfully', 'data' => $travel], 201);

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