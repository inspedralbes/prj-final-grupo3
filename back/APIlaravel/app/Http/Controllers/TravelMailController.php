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
    public function send(string $id)
    {
        try {
            Log::info("Sol·licitud per enviar el pla de viatge amb ID: $id");

            $user = Auth::user();
            Log::info("Usuari autenticat: {$user->id} - {$user->email}");

            // Verificar que el viatge existeix i pertany a l'usuari autenticat
            $travel = Travel::where('id', $id)
                ->where('id_user', $user->id)
                ->first();

            if (!$travel) {
                Log::error("Viatge no trobat o no autoritzat. ID: $id, Usuari: {$user->id}");
                return response()->json([
                    'status' => 'error',
                    'message' => 'Viatge no trobat o no autoritzat.',
                ], 404);
            }

            // Carregar el TravelPlan i relacions
            $travelPlan = TravelPlan::with(['days.activities'])
                ->where('travel_id', $id)
                ->first();

            if (!$travelPlan) {
                Log::error("No s'ha trobat cap TravelPlan per al viatge amb ID $id");
                return response()->json([
                    'status' => 'error',
                    'message' => 'No s\'ha trobat cap pla de viatge per aquest viatge.',
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
                    'dia' => \Carbon\Carbon::parse($day->date)->isoFormat('dddd D [de] MMMM [de] YYYY'),
                    'resumDia' => null,
                    'paraulaClau' => null,
                    'allotjament' => $day->accommodation,
                    'activitats' => $day->activities->map(function ($act) {
                        return [
                            'nom' => $act->name,
                            'descripcio' => $act->description,
                            'preu' => $act->price ?? 'Preu no disponible',
                            'horari' => ($act->start_time ? \Carbon\Carbon::parse($act->start_time)->format('H:i') : '–') .
                                        ' - ' .
                                        ($act->end_time ? \Carbon\Carbon::parse($act->end_time)->format('H:i') : '–'),
                        ];
                    })->toArray()
                ];
            }

            Log::info("Dades de planificació compilades correctament.");

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

            // Log::info("Correu enviat correctament a {$user->email}");

            return response()->json([
                'status' => 200,
                'message' => 'El correu amb el pla de viatge s\'ha enviat correctament.',
                'viatge' => $planning['viatge'],
            ]);

        } catch (\Throwable $e) {
            Log::error("Error inesperat: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error inesperat: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ], 500);
        }
    }
}
