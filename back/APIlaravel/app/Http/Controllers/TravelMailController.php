<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\TravelPlan;

class TravelMailController extends Controller
{
    public function send(Request $request, $id)
    {
        Log::info("➡️ Enviant email per al viatge amb ID: $id, $request ");

        $userData = $request->all();

        // dd('Dades de l\'usuari', $userData, 'ID del viatge', $id);

        Log::info("Dades de l'usuari:", ['id' => $id, 'email' => $userData['email'], 'id_user' => $userData['id']]);

        $travel = TravelPlan::where('travel_id', $id)->get()->first();

        if (!$travel) {
            Log::error("No s'ha trobat cap viatge amb ID $id per a l'usuari {$userData['id']}");
            return response()->json([
                'status' => 'error',
                'message' => 'Viatge no trobat o no autoritzat.',
            ], 404);
        } else {
            Log::info("Viatge trobat correctament, amb dades: ", ['travel' => $travel]);
        }

        try {
            // Generar el PDF
            // $pdf = Pdf::loadView('pdf.planning', ['planning' => $planning]);

            // // Enviar el correu
            // Mail::send('sendemail', ['user' => $user, 'planning' => $planning], function ($message) use ($user, $pdf) {
            //     $message->to($user->email)
            //         ->subject('El teu pla de viatge')
            //         ->attachData($pdf->output(), 'planificacio_viatge.pdf', [
            //             'mime' => 'application/pdf',
            //         ]);
            // });
            // $pdf = Pdf::loadView('pdf.planning', ['planning' => $planning]);


            // Log::info("Correu enviat correctament a {$user->email}");

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
