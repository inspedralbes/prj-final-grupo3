<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserApiController extends Controller
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
    public function update(Request $request)
    {
        $user = auth()->user();
        $id = $user->id;
        // try {
        //     $validated = $request->validate([
        //         'name' => 'nullable|string|max:255',
        //         'surname' => 'nullable|string|max:255',
        //         'email' => 'nullable|string|email|max:255|unique:users,email,' . $id,
        //         'email_alternative' => 'nullable|string|email|max:255|unique:users,email_alternative,' . $id,
        //         'birth_date' => 'nullable',
        //         'phone_number' => 'nullable|digits:9',
        //     ]);

        //     // $user = $request->user();
        //     $user->update($validated);

        //     return response()->json(['message' => 'Usuari correctament actualitzat', 'user' => $user, 'code' => 200], 200);
        // } catch (\Illuminate\Validation\ValidationException $e) {
        //     return response()->json(['errors' => $e->errors()], 422);
        // } catch (\Exception $e) {
        //     return response()->json(['error' => 'Error al actualizar usuario'], 500);
        // }

        // Encuentra al usuario
        // $user = auth()->user();
        // $id = $user->id;
        // dd($user->birth_date);


        // Validación de los datos de entrada
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'surname' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $id,
            'email_alternative' => 'nullable|string|email|max:255|unique:users,email_alternative,' . $id,
            'birth_date' => 'nullable|date',
            'phone_number' => 'nullable|digits:9',
        ]);

        // Verifica si 'birth_date' está en los datos validados y actualiza el usuario
        $user->update([
            'name' => $validated['name'] ?? $user->name,
            'surname' => $validated['surname'] ?? $user->surname,
            'email' => $validated['email'] ?? $user->email,
            'email_alternative' => $validated['email_alternative'] ?? $user->email_alternative,
            'birth_date' => $validated['birth_date'] ?? $user->birth_date, 
            'phone_number' => $validated['phone_number'] ?? $user->phone_number,
        ]);

        $user->save();

        return response()->json(['message' => 'Usuari correctament actualitzat', 'user' => $user, 'code' => 200], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Show user travel history
     */
    public function travelHistory(string $id) {
        $user = User::with(['travels.country', 'travels.type', 'travels.movility', 'travels.budget', 'travels.user'])->where('id', $id)->first();        
        return response()->json($user);
    }
}
