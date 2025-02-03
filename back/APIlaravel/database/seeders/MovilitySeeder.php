<?php

namespace Database\Seeders;

use App\Models\Movility;
use Illuminate\Database\Seeder;
use Illuminate\Database\QueryException;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MovilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $file_json = "./public/user_data.json";
            $json = file_get_contents($file_json);
            $movilities = json_decode($json, true);

            foreach ($movilities["movilities"] as $movility) {
                Movility::create([
                    'type' => $movility['type'],
                ]);
            }
        } catch (QueryException $e) {
            echo "Error al conectarse a la base de datos: " . $e->getMessage();
        }
    }
}
