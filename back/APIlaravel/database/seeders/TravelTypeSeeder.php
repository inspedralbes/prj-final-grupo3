<?php

namespace Database\Seeders;

use App\Models\TravelType;
use Illuminate\Database\Seeder;
use Illuminate\Database\QueryException;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TravelTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $file_json = "./public/user_data.json";
            $json = file_get_contents($file_json);
            $travel_types = json_decode($json, true);

            foreach ($travel_types["travel_types"] as $travel_type) {
                TravelType::create([
                    'type' => $travel_type['type'],
                ]);
            }
        } catch (QueryException $e) {
            echo "Error al conectarse a la base de datos: " . $e->getMessage();
        }
    }
}
