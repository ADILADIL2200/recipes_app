<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin fixe
        User::factory()->admin()->create([
            'name'  => 'Admin',
            'email' => 'admin@recettes.com',
        ]);

        // User fixe pour tester
        User::factory()->create([
            'name'  => 'Test User',
            'email' => 'user@recettes.com',
        ]);

        // 10 users aléatoires
        User::factory(10)->create();
    }
}