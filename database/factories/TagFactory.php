<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TagFactory extends Factory
{
    public function definition(): array
    {
        $tags = [
            'Végétarien', 'Vegan', 'Sans gluten', 'Rapide', 'Facile',
            'Économique', 'Healthy', 'Épicé', 'Sans lactose', 'Bio',
            'Traditionnel', 'Exotique', 'Fait maison', 'Léger', 'Gourmand',
        ];

        $name = fake()->unique()->randomElement($tags);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}