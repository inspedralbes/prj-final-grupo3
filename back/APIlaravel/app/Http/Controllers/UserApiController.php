<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Travel;
use Illuminate\Http\Request;
use App\Models\FavoriteTravel;
use Illuminate\Support\Facades\Log;


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
    try {
      $user = auth()->user();
      $id = $user->id;

      // Validation input data
      $validated = $request->validate([
        'name' => 'nullable|string|max:255',
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'surname' => 'nullable|string|max:255',
        'email' => 'nullable|string|email|max:255|unique:users,email,' . $id,
        'email_alternative' => 'nullable|string|email|max:255|unique:users,email_alternative,' . $id,
        'birth_date' => 'nullable|date',
        'phone_number' => 'nullable|digits:9',
      ]);

      if ($request->hasFile('avatar')) {
        $file = $request->file('avatar');
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('avatars'), $filename);

        $user->avatar = 'avatars/' . $filename;
      }


      $user->update([
        'name' => $validated['name'] ?? $user->name,
        'surname' => $validated['surname'] ?? $user->surname,
        'email' => $validated['email'] ?? $user->email,
        'email_alternative' => $validated['email_alternative'] ?? $user->email_alternative,
        'birth_date' => $validated['birth_date'] ?? $user->birth_date,
        'phone_number' => $validated['phone_number'] ?? $user->phone_number,
      ]);

      $user->save();

      return response()->json([
        'message' => 'Informació correctament actualitzat',
        'status' => 'success',
        'user' => $user,
        'code' => 200
      ], 200);
    } catch (\Illuminate\Validation\ValidationException $e) {
      return response()->json([
        'message' => 'Error de validació',
        'status' => 'error',
        'error' => $e->errors(),
        'code' => 422
      ], 422);
    } catch (\Exception $e) {
      return response()->json([
        'message' => 'Error actualitzant usuari',
        'status' => 'error',
        'error' => $e->getMessage(),
        'code' => 400
      ], 400);
    }
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
  public function travelHistory(string $id)
  {
    $user = User::with(['travels.country', 'travels.type', 'travels.movility', 'travels.budget', 'travels.user'])->where('id', $id)->first();
    return response()->json($user);
  }

  /**
   * Delete travel
   */
  public function deleteTravel($userId, $tripId)
  {
    $user = User::find($userId);
    if (!$user) {
      return response()->json(['message' => 'Usuari ' . $userId . ' no trobat'], 404);
    }

    $travel = $user->travels()->find($tripId);
    if (!$travel) {
      return response()->json(['message' => 'Viaje ' . $tripId . 'no trobat'], 404);
    }

    $travel->delete();
    return response()->json(['message' => 'Viatge: ' . $tripId . ' eliminat correctament'], 200);
  }

  public function toggleFavorite(Request $request)
  {
    $userId = $request->user()->id; // Obtener el ID del usuario autenticado
    $travelId = $request->input('travel_id'); // ID del viaje enviado desde el frontend

    // Validar que el viaje existe
    $travel = Travel::find($travelId);

    if (!$travel) {
      return response()->json(['message' => 'Viatge no trobat'], 404);
    }

    // Verificar si ya está en favoritos
    $favorite = FavoriteTravel::where('user_id', $userId)->where('travel_id', $travelId)->first();

    if ($favorite) {
      // Si ya está en favoritos, eliminarlo
      $favorite->delete();
      return response()->json(['message' => 'Viatge eliminat dels favorits'], 200);
    } else {
      // Si no está en favoritos, agregarlo
      FavoriteTravel::create([
        'user_id' => $userId,
        'travel_id' => $travelId,
      ]);
      return response()->json(['message' => 'Viatge afegit als favorits'], 201);
    }
  }
  
  public function getUserFavorites(Request $request)
  {
    $user = $request->user();

    $favorites = $user->favoriteTravels()->with('travel')->get();

    return response()->json($favorites);
  }
}
