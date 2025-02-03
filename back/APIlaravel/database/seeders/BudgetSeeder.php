<?php

namespace Database\Seeders;

use App\Models\Budget;
use GuzzleHttp\Psr7\Query;
use Illuminate\Database\Seeder;
use Illuminate\Database\QueryException;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BudgetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $file_json = "./public/user_data.json";
            $json = file_get_contents($file_json);
            $budgets = json_decode($json, true);

            foreach ($budgets["budgets"] as $budget) {
                Budget::create([
                    'min_budget' => $budget['min_budget'],
                    'max_budget' => $budget['max_budget'],
                    'final_price' => $budget['final_price'],
                ]);
            }
        } catch (QueryException $e) {
            echo "Error al conectarse a la base de datos: " . $e->getMessage();
        }
    }
}
