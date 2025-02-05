<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        // Validación para los campos que pueden ser actualizados
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'surname' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:users,email,' . $id,
            'email_alternative' => 'nullable|string|email|max:255|unique:users,email_alternative,' . $id,
            // 'password' => 'nullable|string|min:8|confirmed',
            'birth_date' => 'nullable|date',
            'phone_number' => 'nullable|string|max:15',
        ]);

        // Actualizar solo los campos validados y presentes en la solicitud
        $user->update(array_filter([
            'name' => $validated['name'] ?? $user->name,
            'surname' => $validated['surname'] ?? $user->surname,
            'email' => $validated['email'] ?? $user->email,
            'email_alternative' => $validated['email_alternative'] ?? $user->email_alternative,
            // 'password' => isset($validated['password']) ? bcrypt($validated['password']) : $user->password,
            'birth_date' => $validated['birth_date'] ?? $user->birth_date,
            'phone_number' => $validated['phone_number'] ?? $user->phone_number,
        ]));

        // Retorna el usuario actualizado
        return response()->json($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
