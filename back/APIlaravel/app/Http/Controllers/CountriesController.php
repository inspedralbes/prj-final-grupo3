<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country; 
class CountriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countries = Country::all();
        return view('admin.countries', compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.country-register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string",
            "code" => "required|string|min:2|max:4",
        ]);

        // Guardar en la base de datos
        Country::create([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
        ]);
        return redirect()->route('countries')->with('success', 'El país se ha añadido correctamente.');
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
        $country = Country::findOrFail($id);
        return view('admin.country-edit', compact('country'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10',
        ]);
    
        $country = Country::findOrFail($id);
        $country->name = $request->name;
        $country->code = $request->code;
        $country->save();
    
        return redirect()->route('countries')->with('success', 'País actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $country = Country::find($id);
        if (!$country) {
            return response()->json(['error' => 'País no encontrado'], 404);
        }
        
        $country->delete();
    
        return response()->json(['success' => 'País eliminat correctament.']);
    }
}
