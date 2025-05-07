<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Travel;

class TravelMailController extends Controller
{
    public function send(Request $request, $id)
    {
        // dd($request->all());

        Log::info("➡️ Enviant email per al viatge amb ID: $id");

        // dd($id);

        $user = Auth::user();
        Log::info("Usuari autenticat:", ['id' => $user->id, 'email' => $user->email]);

        $travel = Travel::where('id', $id)
            ->where('id_user', $user->id)
            ->first();

        if (!$travel) {
            Log::error("No s'ha trobat cap viatge amb ID $id per a l'usuari {$user->id}");
            return response()->json([
                'status' => 'error',
                'message' => 'Viatge no trobat o no autoritzat.',
            ], 404);
        }

        if (!$travel->planning_json) {
            Log::error("El viatge amb ID $id no té JSON de planificació.");
            return response()->json([
                'status' => 'error',
                'message' => 'Aquest viatge no té dades de planificació.',
            ], 422);
        }

        $planning = json_decode($travel->planning_json, true);

        if (!$planning || !isset($planning['viatge'])) {
            Log::error("Error al parsejar el planning_json del viatge $id.");
            return response()->json([
                'status' => 'error',
                'message' => 'El JSON del viatge no és vàlid.',
            ], 500);
        }

        Log::info("JSON de planificació carregat correctament.");

        try {
            // Generar el PDF
            $pdf = Pdf::loadView('pdf.planning', ['planning' => $planning]);

            // Enviar el correu
            Mail::send('sendemail', ['user' => $user, 'planning' => $planning], function ($message) use ($user, $pdf) {
                $message->to($user->email)
                        ->subject('El teu pla de viatge')
                        ->attachData($pdf->output(), 'planificacio_viatge.pdf', [
                            'mime' => 'application/pdf',
                        ]);
            });
            $pdf = Pdf::loadView('pdf.planning', ['planning' => $planning]);


            Log::info("Correu enviat correctament a {$user->email}");

            return response()->json([
                'status' => 'ok',
                'message' => 'El correu amb el pla de viatge s\'ha enviat correctament.',
            ]);
        } catch (\Exception $e) {
            Log::error("Error en enviar el correu: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'No s\'ha pogut enviar el correu.',
            ], 500);
        }
    }
}
