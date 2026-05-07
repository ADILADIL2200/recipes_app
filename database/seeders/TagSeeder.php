<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'Végétarien', 'Vegan', 'Sans gluten', 'Rapide', 'Facile',
            'Économique', 'Healthy', 'Épicé', 'Sans lactose', 'Bio',
            'Traditionnel', 'Exotique', 'Fait maison', 'Léger', 'Gourmand',
        ];

        foreach ($tags as $name) {
            Tag::create([
                'name' => $name,
                'slug' => Str::slug($name),
            ]);
        }
    }
}