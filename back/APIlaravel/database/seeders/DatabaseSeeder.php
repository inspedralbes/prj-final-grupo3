<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Movility;
use App\Models\Travel;
use App\Models\User;
use App\Models\TravelType;
use App\Models\Budget;
use App\Models\RecommendedTrip;
use Database\Seeders\AdminSeeder;
use Database\Seeders\BudgetSeeder;
use Database\Seeders\ImportJson;
use Database\Seeders\MovilitySeeder;
use Database\Seeders\RecommendedTripsSeeder;
use Database\Seeders\TravelSeeder;
use Database\Seeders\TravelTypeSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\CommentSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
            RecommendedTripsSeeder::class,
            CommentSeeder::class,
        ]);

    }
}
