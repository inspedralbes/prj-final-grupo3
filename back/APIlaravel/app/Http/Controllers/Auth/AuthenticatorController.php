<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class AuthenticatorController extends Controller
{

    public function authenticate(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            if (Auth::attempt($credentials)) {

                $user = Auth::user();

                $token = $user->createToken('auth_token')->plainTextToken;

                return response()->json(['status' => 'success', 'message' => 'Credencials validades', 'token' => $token, 'user' => $user]);
            }

            return response()->json(['status' => 'error', 'message' => 'Correu o contrasenya incorrectes'], 401);

        } catch (\Exception $e) {

            return response()->json(['status' => 'error', 'message' => 'Error en la validació'], 500);

        }

    }

    public function register(Request $request)
    {
        try {
            // Validar los datos
            $data = $request->validate(
                [
                    'name' => 'required|string|max:255',
                    'surname' => 'required|string|max:255', // Campo apellido agregado
                    'email' => 'required|string|email|max:255|unique:users',
                    'email_alternative' => 'required|string|email|max:255|unique:users',
                    'password' => 'required|string|min:8|confirmed',
                    'birth_date' => 'required|date', // Campo fecha de nacimiento agregado
                    'phone_number' => 'required|integer', // Campo número de teléfono agregado
                    'gender' => 'required|string|in:male,female,other', // Campo género agregado con validación
                    'id_travel' => 'nullable|exists:travels,id', // Asumiendo que id_travel es opcional y existe en la tabla travels
                ],
                [
                    'name.required' => 'El camp name es obligatori',
                    'surname.required' => 'El camp cognom es obligatori',
                    'email.required' => 'El camp email es obligatori',
                    'email.email' => 'Direcció de correu electrònic inválida',
                    'email_alternative.required' => 'El camp email alternatiu es obligatori',
                    'email_alternative.email' => 'Direcció de correu electrònic inválida',
                    'password.required' => 'El camp password es obligatori',
                    'birth_date.required' => 'El camp data naixemnet es obligatori',
                    'phone_number.required' => 'El campo telefón es obligatori',
                    'gender.required' => 'El camp sexe es obligatori',
                ]
            );

            $user = new User();
            $user->name = $data['name'];
            $user->surname = $data['surname'];
            $user->email = $data['email'];
            $user->email_alternative = $data['email_alternative'];
            $user->password = bcrypt($data['password']);
            $user->birth_date = $data['birth_date'];
            $user->phone_number = $data['phone_number'];
            $user->gender = $data['gender'];
            if($data['gender'] == 'male') {                
                $user->avatar = './public/default_avatar_male.png';
            } else {
                $user->avatar = './public/default_avatar_female.png';
            }
            $user->save();

            // dd($data['gender']);

            // Crear el token de acceso
            $token = $user->createToken('auth_token')->plainTextToken;
            Auth::login($user);

            return response()->json([
                'status' => 'success',
                'message' => 'User created',
                'token' => $token,
                'user' => $user
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Verify if the email is already in use
            $errors = $e->errors();
            if (isset($errors['email'])) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'El correu ja está en us',
                    'errors' => $errors['email'],
                ], 422);
            }
            // Many errors
            return response()->json([
                'status' => 'error',
                'message' => 'Error en la validació',
                'errors' => $errors,
            ], 422);

        } catch (\Exception $e) {
            // Inesrate errors
            return response()->json([
                'status' => 'error',
                'message' => 'Ocurrió un error inesperado',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function logout(Request $request)
    {

        // Obtener el usuario autenticado
        $user = Auth::user();

        if ($user) {
            // Revocar el token actual del usuario
            $user->currentAccessToken()->delete();

            return response()->json([
                'message' => 'Sessió tancada correctament',
            ], 200);
        }

        return response()->json([
            'message' => 'Usuari no trobat',
        ], 401);
    }

    public function currentUser()
    {
        $user = auth()->user();

        if ($user) {
            return response()->json([
                'status' => 'success',
                'user' => $user,
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'No authenticated user found',
        ], 401);
    }
}