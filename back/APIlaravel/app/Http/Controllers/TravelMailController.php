<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Travel;
use App\Models\TravelPlan;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;

class TravelMailController extends Controller
{
    public function send(Request $request, string $id)
    {
        $user = User::find($request->id);

        if (!$user) {
            return response()->json(['message' => 'Usuari no trobat'], 404);
        }

        $travel = Travel::where('id', $id)->where('id_user', $user->id)->first();
        if (!$travel) {
            return response()->json(['message' => 'Viatge no trobat'], 404);
        }

        $travelPlan = TravelPlan::with(['days.activities'])
            ->where('travel_id', $id)
            ->first();

        if (!$travelPlan) {
            return response()->json(['message' => 'Pla de viatge no trobat'], 404);
        }

        $planning = [
            'viatge' => [
                'titol' => $travelPlan->title,
                'preuTotal' => $travelPlan->total_price,
                'dies' => $travelPlan->days->map(function ($day) {
                    return [
                        'dia' => \Carbon\Carbon::parse($day->date)->isoFormat('dddd D [de] MMMM [de] YYYY'),
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
                        }),
                    ];
                }),
            ]
        ];

        $pdf = Pdf::loadView('pdf.planning', ['planning' => $planning]);

        Mail::send('sendemail', ['user' => $user, 'planning' => $planning], function ($message) use ($user, $pdf) {
            $message->to($user->email)
                ->subject('El teu pla de viatge')
                ->attachData($pdf->output(), 'planificacio_viatge.pdf');
        });

        return response()->json([
            'message' => 'Correu enviat correctament',
            'viatge' => $planning['viatge']
        ]);
    }
}