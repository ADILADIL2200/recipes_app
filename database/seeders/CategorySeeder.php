<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Entrées',        'icon' => '🥗', 'description' => 'Soupes, salades et amuse-bouches'],
            ['name' => 'Plats',          'icon' => '🍽️', 'description' => 'Plats principaux chauds et froids'],
            ['name' => 'Desserts',       'icon' => '🍰', 'description' => 'Gâteaux, tartes et douceurs'],
            ['name' => 'Soupes',         'icon' => '🍲', 'description' => 'Soupes et veloutés'],
            ['name' => 'Salades',        'icon' => '🥙', 'description' => 'Salades composées et fraîches'],
            ['name' => 'Boissons',       'icon' => '🥤', 'description' => 'Jus, smoothies et cocktails'],
            ['name' => 'Petit déjeuner', 'icon' => '🥐', 'description' => 'Recettes du matin'],
            ['name' => 'Snacks',         'icon' => '🍿', 'description' => 'En-cas et collations'],
        ];

        foreach ($categories as $cat) {
            Category::create([
                'name'        => $cat['name'],
                'slug'        => Str::slug($cat['name']),
                'icon'        => $cat['icon'],
                'description' => $cat['description'],
            ]);
        }
    }
}