<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Movility;
use App\Models\Travel;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        $this->call([
            ImportJson::class,
            UserSeeder::class,
            AdminSeeder::class,
            TravelTypeSeeder::class,
            BudgetSeeder::class,
            MovilitySeeder::class,
            TravelSeeder::class,
        ]);

    }
}
