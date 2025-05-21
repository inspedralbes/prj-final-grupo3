<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validación de los datos
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Intentar autenticar al admin utilizando el guard 'admin'
        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        // Verificar si las credenciales son correctas usando el guard 'admin'
        if (Auth::guard('admin')->attempt($credentials)) {
            // Si la autenticación es exitosa, redirigir al panel de administración
            return redirect()->route('users');
        } else {
            // Si las credenciales no son correctas, devolver un error
            return back()->withErrors(['username' => 'Credencials incorrectes.'])->withInput();
        }
    }

    public function register(Request $request)
{
    // Validar los datos del usuario
    $request->validate([
        'name' => 'required|string|max:255',
        'surname' => 'required|string|max:255',
        'email' => 'required|email|unique:admins,email',
        'email_alternative' => 'nullable|email',
        'password' => 'required|string|min:8|confirmed',
    ]);

    // Crear el usuario admin
    $admin = Admin::create([
        'name' => $request->name,
        'surname' => $request->surname,
        'email' => $request->email,
        'email_alternative' => $request->email_alternative,
        'password' => bcrypt($request->password), // Encriptar la contraseña
    ]);

    return response()->json(['message' => 'Administrador registrado correctamente'], 201);
}

    // En el controlador AuthController:
    public function logout()
    {
        Auth::logout();  // Cerrar sesión
        return redirect()->route('login');  // Redirigir al home
    }
}
