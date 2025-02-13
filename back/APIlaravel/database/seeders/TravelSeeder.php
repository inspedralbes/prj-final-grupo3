<?php

namespace Database\Seeders;

use App\Models\Travel;
use Illuminate\Database\Seeder;
use Illuminate\Database\QueryException;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TravelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $file_json = "./public/user_data.json";
            $json = file_get_contents($file_json);
            $travels = json_decode($json, true);

            foreach ($travels["travels"] as $travel) {
                Travel::create([
                    'id_user' => $travel['id_user'],
                    'id_country' => $travel['id_country'],
                    'id_type' => $travel['id_type'],
                    'id_budget' => $travel['id_budget'],
                    'id_movility' => $travel['id_movility'],
                    'qunt_date' => $travel['qunt_date'],
                    'date_init' => $travel['date_init'],
                    'date_end' => $travel['date_end'],
                    'description' => $travel['description'],
                ]);
            }
        } catch (QueryException $e) {
            echo "Error al conectarse a la base de datos: " . $e->getMessage();
        }
    }
}
