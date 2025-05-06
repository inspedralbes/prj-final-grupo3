<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TravelPlan;

class TravelPlanController extends Controller
{
  public function index()
  {
    $travelPlans = TravelPlan::all();
    return response()->json($travelPlans);
  }

  public function show($id)
  {
    $travelPlan = TravelPlan::find($id);
    if (!$travelPlan) {
      return response()->json(['message' => 'Travel plan not found'], 404);
    }
    return response()->json($travelPlan);
  }

  public function storeTravelPlan(Request $request)
  {
    try {
      $request->validate([
        'travel_id' => 'required',
        'viatge.titol' => 'required|string',
        'viatge.preuTotal' => 'required|numeric',
        'viatge.dies' => 'required|array'
      ]);

      // 1. Create a TravelPlan
      $travelPlan = TravelPlan::create([
        'travel_id' => $request->travel_id,
        'title' => $request->viatge['titol'],
        'total_price' => $request->viatge['preuTotal'],
      ]);

      // 2. Create TravelDay and Activities for each on
      foreach ($request->viatge['dies'] as $index => $dia) {
        $travelDay = $travelPlan->days()->create([
          'date' => $this->parseDate($dia['dia']), // Helper function to parse the date
          'accommodation' => $dia['allotjament'],
          'day_number' => $index + 1
        ]);

        // 3. Create activities for each day
        foreach ($dia['activitats'] as $actIndex => $activitat) {
          // Split schedule into start and end
          list($startTime, $endTime) = $this->parseTimeRange($activitat['horari']);

          $travelDay->activities()->create([
            'name' => $activitat['nom'],
            'description' => $activitat['descripcio'],
            'price' => $this->extractPrice($activitat['preu']),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'order' => $actIndex + 1
          ]);
        }
      }

      return response()->json(['message' => 'Plan created successfully', 'plan' => $travelPlan->load('days.activities')]);
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 500);
    }
  }

  // Helper functions
  private function parseDate(string $dateString): string
  {
    // Delete the day of the week and the word "of"
    $dateString = preg_replace('/^[^,]*, /', '', $dateString);
    $dateString = str_replace(" de ", " ", $dateString);

    // Month mapping in Catalan to numbers
    $months = [
      'gener' => '01',
      'febrer' => '02',
      'març' => '03',
      'abril' => '04',
      'maig' => '05',
      'juny' => '06',
      'juliol' => '07',
      'agost' => '08',
      'setembre' => '09',
      'octubre' => '10',
      'novembre' => '11',
      'desembre' => '12'
    ];

    // Extract the date components
    preg_match('/(\d+) ([^ ]+) (\d{4})/', $dateString, $matches);

    if (count($matches) < 4) {
      throw new \Exception('Format de data no vàlid');
    }

    $day = str_pad($matches[1], 2, '0', STR_PAD_LEFT);
    $month = $months[strtolower($matches[2])] ?? '01';
    $year = $matches[3];

    return sprintf('%s-%s-%s', $year, $month, $day);
  }

  private function parseTimeRange(string $timeRange): array
  {
    // Verificar si existe el formato esperado con un guion
    if (strpos($timeRange, ' - ') !== false) {
      $times = explode(' - ', $timeRange);
      return [$times[0], $times[1] ?? null]; // Usar null como valor predeterminado
    }

    // Si no tiene el formato esperado, devolver valores nulos
    return [null, null];
  }

  private function extractPrice(string $priceString): ?float
  {
    // Extract number "30€ (aprox.)" -> 30.00
    preg_match('/(\d+)/', $priceString, $matches);
    return $matches[1] ?? null;
  }
}
