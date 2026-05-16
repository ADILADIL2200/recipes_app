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
            // Régimes alimentaires
            'Végétarien', 'Vegan', 'Sans gluten', 'Sans lactose', 'Sans œufs',
            'Bio', 'Cru', 'Halal', 'Casher',

            // Niveau & temps de préparation
            'Facile', 'Intermédiaire', 'Chef', 'Rapide', 'Moins de 30 min',
            'Moins de 15 min', 'Longue cuisson', 'Préparation à l\'avance',

            // Caractéristiques nutritionnelles
            'Healthy', 'Léger', 'Riche en protéines', 'Faible en calories',
             'Fait maison',

            // Goût & texture
            'Épicé', 'Gourmand', 'Croustillant', 'Fondant', 'Moelleux',
            'Umami', 'Aigre-doux', 'Fumé', 'Sucré-salé',

            // Occasion
            'Repas de fête', 'Brunch', 'Pique-nique', 'Barbecue', 'Apéritif',
            'Repas en famille', 'Repas romantique', 'Batch cooking', 'Repas froid',

            // Origine culinaire
            'Traditionnel', 'Exotique', 'Méditerranéen', 'Asiatique',
            'Français', 'Italien', 'Mexicain', 'Indien', 'Marocain', 'Japonais',

            // Saison
            'Printemps', 'Été', 'Automne', 'Hiver',
        ];

        foreach ($tags as $name) {
            Tag::create([
                'name' => $name,
                'slug' => Str::slug($name),
            ]);
        }
    }
}
