<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\QueryException;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $file_json = "./public/user_data.json";
            $json = file_get_contents($file_json);
            $users = json_decode($json, true);

            // Insert data
            foreach ($users["users"] as $user) {
                User::create([
                    'name' => $user['name'],
                    'surname' => $user['surname'],
                    'birth_date' => $user['birth_date'],
                    'email' => $user['email'],
                    'email_alternative' => $user['email_alternative'],
                    'password' => bcrypt($user['password']),
                    'phone_number' => $user['phone_number'],
                    'avatar' => $user['avatar'],
                    'gender' => $user['gender'],
                    'remember_token' => $user['remember_token'],
                ]);
            }
        } catch (QueryException $e) {
            echo "Error al conectarse a la base de datos: " . $e->getMessage();
        }
    }
}
