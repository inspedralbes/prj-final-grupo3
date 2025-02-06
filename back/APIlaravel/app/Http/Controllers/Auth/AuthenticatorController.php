<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SendMail;


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
                $user = User::where('email', $credentials['email'])->first();

                $token = $user->createToken('auth_token')->plainTextToken;

                return response()->json(['status' => 'success', 'message' => 'Credencials validades', 'token' => $token, 'user' => $user]);
            } 

            return response()->json(['status' => 'error', 'message' => 'Correu o contrasenya incorrectes'], 401);

        } catch (\Exception $e) {

            return response()->json(['status' => 'error', 'message' => 'Error en la validació'], 500);

        } catch (\Exception $e) {
            return response()->json(['status' => 'nullToken', 'message' => 'Correu o contrasenya incorrectes'], 405);
        }

    }

    public function register(Request $request)
    {
        try {
            // Validar los datos
            $data = $request->validate(
                [
                    'name' => 'required|string|max:255',
                    'surname' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:users',
                    'email_alternative' => 'required|string|email|max:255|unique:users',
                    'password' => 'required|string|min:8|confirmed',
                    'birth_date' => 'required|date',
                    'phone_number' => 'required|integer',
                    'gender' => 'required|string|in:male,female,other',
                ],
                [
                    'name.required' => 'El campo name es obligatorio',
                    'surname.required' => 'El campo surname es obligatorio',
                    'email.required' => 'El campo email es obligatorio',
                    'email.email' => 'Dirección de correo electrónico inválida',
                    'email_alternative.required' => 'El campo email alternativo es obligatorio',
                    'email_alternative.email' => 'Dirección de correo electrónico inválida',
                    'password.required' => 'El campo password es obligatorio',
                    'birth_date.required' => 'El campo fecha de nacimiento es obligatorio',
                    'phone_number.required' => 'El campo teléfono es obligatorio',
                    'gender.required' => 'El campo gender es obligatorio',
                ]
            );
    
            // Crear el usuario
            $user = new User();
            $user->name = $data['name'];
            $user->surname = $data['surname'];
            $user->email = $data['email'];
            $user->email_alternative = $data['email_alternative'];
            $user->password = bcrypt($data['password']);
            $user->birth_date = $data['birth_date'];
            $user->phone_number = $data['phone_number'];
            $user->gender = $data['gender'];
    
            // Asignar avatar por defecto según el género
            if ($data['gender'] == 'male') {
                $user->avatar = '/default_avatar_male.png';
            } else {
                $user->avatar = '/default_avatar_female.png';
            }
    
            $user->save();
    
            // Preparar los datos para el correo electrónico
            $subject = "Bienvenido a nuestra plataforma";
            $message = "Hola {$user->name}, gracias por registrarte.";
            $to = [$user->email]; // Usamos el correo del usuario registrado
    
            // Instanciar el controlador SendMail y enviar el correo
            $sendMailController = new SendMail();
            $response = $sendMailController->sendEmail(new Request([
                'subject' => $subject,
                'message' => $message,
                'to' => $to,
            ]));
    
            // Verificar si el correo fue enviado correctamente
            if ($response->getStatusCode() !== 200) {
                // Si falla el envío del correo, seguimos con el registro pero avisamos
                return response()->json([
                    'status' => 'warning',
                    'message' => 'User created, but email sending failed.',
                    'token' => $user->createToken('auth_token')->plainTextToken,
                    'user' => $user,
                ], 201);
            }
    
            // Crear token de acceso
            $token = $user->createToken('auth_token')->plainTextToken;
    
            // Iniciar sesión
            Auth::login($user);
    
            return response()->json([
                'status' => 'success',
                'message' => 'User created and email sent successfully.',
                'token' => $token,
                'user' => $user,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Verificar si el correo ya está en uso
            $errors = $e->errors();
            if (isset($errors['email'])) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'El correu ja está en us',
                    'errors' => $errors['email'],
                ], 422);
            }
            // Muchos errores
            return response()->json([
                'status' => 'error',
                'message' => 'Error en la validació',
                'errors' => $errors,
            ], 422);
        } catch (\Exception $e) {
            // Errores inesperados
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
    try {
        $user = auth()->user();

        if ($user) {
            return response()->json([
                'status' => 'success',
                'user' => $user,
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'La sessió a expirat',
        ], 405);

    } catch (\Exception $e) {
        
        return response()->json([
            'status' => 'error',
            'message' => 'No hi ha un usuari autenticat',
        ], 401);
    }
}
}

