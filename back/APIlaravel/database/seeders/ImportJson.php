<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class ImportJson extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {

            $file_json = "./public/country_data.json";
            $json = file_get_contents($file_json);
            $countries = json_decode($json, true);

            // Insert data
            foreach ($countries["countries"] as $country) {
                Country::create([
                    'name' => $country['name'],
                    'code' => $country['code'],
                ]);
            }

            echo "Datos insertados correctamente";
        } catch (QueryException $e) {
            echo "Error al conectarse a la base de datos: " . $e->getMessage();
        }
    }
}