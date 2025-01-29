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
            return back()->withErrors(['username' => 'Credenciales incorrectas.'])->withInput();
        }
    }

    // En el controlador AuthController:
    public function logout()
    {
        Auth::logout();  // Cerrar sesión
        return redirect()->route('login');  // Redirigir al home
    }
}
