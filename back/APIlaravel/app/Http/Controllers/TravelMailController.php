<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Travel;
use App\Models\TravelPlan;

class TravelMailController extends Controller
{
    public function send(string $travelId)
    {
        Log::info("Sol·licitud per enviar el pla de viatge amb ID: $travelId");

        $user = Auth::user();
        Log::info("Usuari autenticat: {$user->id} - {$user->email}");

        // Verificar que el viatge existeix i pertany a l'usuari autenticat
        $travel = Travel::where('id', $travelId)
                        ->where('id_user', $user->id)
                        ->first();

        if (!$travel) {
            Log::error("Viatge no trobat o no autoritzat. ID: $travelId, Usuari: {$user->id}");
            return response()->json([
                'status' => 'error',
                'message' => 'Viatge no trobat o no autoritzat.',
            ], 404);
        }

        // Carregar el TravelPlan i relacions
        $travelPlan = TravelPlan::with(['days.activities'])
                        ->where('travel_id', $travelId)
                        ->first();

        if (!$travelPlan) {
            Log::error("TravelPlan no trobat per al viatge $travelId");
            return response()->json([
                'status' => 'error',
                'message' => 'No s\'ha trobat cap pla de viatge.',
            ], 404);
        }

        // Construir array de planificació
        $planning = [
            'viatge' => [
                'titol' => $travelPlan->title,
                'preuTotal' => $travelPlan->total_price,
                'dies' => []
            ]
        ];
        
        foreach ($travelPlan->days as $day) {
            $planning['viatge']['dies'][] = [
                'dia' => \Carbon\Carbon::parse($day->date)->isoFormat('dddd D [de] MMMM [de] YYYY'), // traducción de fecha en catalán
                'resumDia' => null, 
                'paraulaClau' => null,
                'allotjament' => $day->accommodation,
                'activitats' => $day->activities->map(function ($act) {
                    return [
                        'nom' => $act->name,
                        'descripcio' => $act->description,
                        'preu' => $act->price ?? 'Preu no disponible',
                        'horari' => $act->start_time . ' - ' . $act->end_time,
                    ];
                })->toArray()
            ];
        }
        

        Log::info("Dades de planificació compilades correctament.");

        try {
            // Generar PDF
            $pdf = Pdf::loadView('pdf.planning', ['planning' => $planning]);

            // Enviar correu amb el PDF
            Mail::send('sendemail', ['user' => $user, 'planning' => $planning], function ($message) use ($user, $pdf) {
                $message->to($user->email)
                        ->subject('El teu pla de viatge')
                        ->attachData($pdf->output(), 'planificacio_viatge.pdf', [
                            'mime' => 'application/pdf',
                        ]);
            });

            Log::info("Correu enviat correctament a {$user->email}");

            return response()->json([
                'status' => 'ok',
                'message' => 'El correu amb el pla de viatge s\'ha enviat correctament.',
                'viatge' => $planning['viatge'], 
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
