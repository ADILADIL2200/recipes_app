<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $categories = [
            ['name' => 'Entrées',       'icon' => '🥗'],
            ['name' => 'Plats',         'icon' => '🍽️'],
            ['name' => 'Desserts',      'icon' => '🍰'],
            ['name' => 'Soupes',        'icon' => '🍲'],
            ['name' => 'Salades',       'icon' => '🥙'],
            ['name' => 'Boissons',      'icon' => '🥤'],
            ['name' => 'Petit déjeuner','icon' => '🥐'],
            ['name' => 'Snacks',        'icon' => '🍿'],
        ];

        $cat = fake()->unique()->randomElement($categories);

        return [
            'name'        => $cat['name'],
            'slug'        => Str::slug($cat['name']),
            'icon'        => $cat['icon'],
            'description' => fake()->sentence(),
        ];
    }
}