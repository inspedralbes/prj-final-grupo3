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
    public function update(Request $request)
    {
        // Recuperar al usuario autenticado
        $user = auth()->user();
        $id = $user->id;

        // Verificar que el ID de la ruta sea el mismo que el ID del usuario autenticado
        if ($user->id !== (int) $id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Validación de los campos que se pueden actualizar
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'surname' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:users,email,' . $id,
            'email_alternative' => 'nullable|string|email|max:255|unique:users,email_alternative,' . $id,
            'birth_date' => 'nullable|date',
            'phone_number' => 'nullable|string|max:15',
        ]);

        // Buscar al usuario a actualizar (el que tiene el ID de la ruta)
        $userToUpdate = User::findOrFail($id);

        // Actualizar solo los campos validados y presentes
        $userToUpdate->update(array_filter([
            'name' => $validated['name'] ?? $userToUpdate->name,
            'surname' => $validated['surname'] ?? $userToUpdate->surname,
            'email' => $validated['email'] ?? $userToUpdate->email,
            'email_alternative' => $validated['email_alternative'] ?? $userToUpdate->email_alternative,
            'birth_date' => $validated['birth_date'] ?? $userToUpdate->birth_date,
            'phone_number' => $validated['phone_number'] ?? $userToUpdate->phone_number,
        ]));

        // Responder con el usuario actualizado
        return response()->json($userToUpdate, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
