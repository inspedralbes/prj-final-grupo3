<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('admin.usuaris', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'email' => 'required|email|unique:users,email',
            'email_alternative' => 'nullable|email|unique:users,email_alternative',
            'password' => 'required|string|min:8',
            'phone_number' => 'required|string|max:15',
            'gender' => 'required|in:Male,Female,Other',
        ]);

        User::create([
            'name' => $request->input('name'),
            'surname' => $request->input('surname'),
            'birth_date' => $request->input('birth_date'),
            'email' => $request->input('email'),
            'email_alternative' => $request->input('email_alternative'),
            'password' => bcrypt($request->input('password')),
            'phone_number' => $request->input('phone_number'),
            'gender' => $request->input('gender'),
        ]);

        return redirect()->route('users')->with('success', 'Usuari creat correctament.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'Usuari no encontrado'], 404);
        }

        $user->delete();

        return response()->json(['success' => 'Usuari eliminat correctament.']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        // dd($user);
        return view('admin.user-edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {        
        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->input('name'),
            'surname' => $request->input('surname'),
            'birth_date' => $request->input('birth_date'),
            'email' => $request->input('email'),
            'email_alternative' => $request->input('email_alternative'),
            'password' => bcrypt($request->input('password')),
            'phone_number' => $request->input('phone_number'),
            'gender' => $request->input('gender', $user->gender),
        ]);
    
        return redirect()->route('users')->with('success', 'Usuari actualitzat amb exit.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        // dd($user);
        return view('admin.user-details', compact('user'));
    }
}
