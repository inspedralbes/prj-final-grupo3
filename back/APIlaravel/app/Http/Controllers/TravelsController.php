<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Budget;
use App\Models\Travel;
use App\Models\Country;
use App\Models\Movility;
use App\Models\TravelType;
use Illuminate\Http\Request;

class TravelsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $countries = Country::all();
        $types = TravelType::all();
        $budgets = Budget::all();
        $movilities = Movility::all();
        $travels = Travel::with(['country', 'type', 'budget', 'movility', 'user'])->get();
        return view('admin.travels', compact('travels', 'users', 'countries', 'types', 'budgets', 'movilities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $users = User::all();
        // $countries = Country::all();
        // $types = TravelType::all();
        // $budgets = Budget::all();
        // $movilities = Movility::all();

        // return view('admin.travels-register', compact('users', 'countries', 'types', 'budgets', 'movilities'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id',
            'id_country' => 'required|exists:countries,id',
            'id_type' => 'required|exists:type,id',
            // 'id_budget' => 'required|exists:budget,id',
            'id_budget_min' => 'required|numeric',
            'id_budget_max' => 'required|numeric',
            // 'id_budget_final' => 'required|numeric',
            'id_movility' => 'required|exists:movilities,id',
            'date_init' => 'required|date',
            'date_end' => 'required|date|after_or_equal:date_init',
            'description' => 'required|string|max:1000',
        ]);

        // Guardar en la tabla budget
        $budget = Budget::create([
            'min_budget' => $request->input('id_budget_min'),
            'max_budget' => $request->input('id_budget_max'),
            // 'final_price' => $request->input('id_budget_final'),
        ]);

        // Guardar en la base de datos
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
        return redirect()->route('travels')->with('success', 'Viaje creado correctamente.');
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
        $users = User::all();
        $countries = Country::all();
        $types = TravelType::all();
        $budgets = Budget::all();
        $movilities = Movility::all();
        $travel = Travel::findOrFail($id);
        return view('admin.travels-edit', compact('travel', 'users', 'countries', 'types', 'budgets', 'movilities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $request->validate([
            'id_user' => 'required|exists:users,id',
            'id_country' => 'required|exists:countries,id',
            'id_type' => 'required|exists:type,id',
            // 'id_budget' => 'required|exists:budget,id',
            'id_budget_min' => 'required|numeric',
            'id_budget_max' => 'required|numeric',
            // 'id_budget_final' => 'required|numeric',
            'id_movility' => 'required|exists:movilities,id',
            'date_init' => 'required|date',
            'date_end' => 'required|date|after_or_equal:date_init',
            'description' => 'required|string|max:1000',
        ]);

        $budget = Budget::create([
            'min_budget' => $request->input('id_budget_min'),
            'max_budget' => $request->input('id_budget_max'),
            // 'final_price' => $request->input('id_budget_final'),
        ]);

        $travel = Travel::findOrFail($id);

        $travel->id_user = $request->id_user;
        $travel->id_country = $request->id_country;
        $travel->id_type = $request->id_type;
        $travel->id_budget = $budget->id;
        $travel->id_movility = $request->id_movility;
        $travel->date_init = $request->date_init;
        $travel->date_end = $request->date_end;
        $travel->description = $request->description;
        $travel->save();

        return redirect()->route('travels')->with('success', 'Viaje actualizado con éxito.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $travel = Travel::find($id);
        if (!$travel) {
            return response()->json(['error' => 'Viaje no trobat'], 404);
        }

        $travel->delete();

        return response()->json(['success' => 'Viatge eliminat correctament.']);
    }
}
