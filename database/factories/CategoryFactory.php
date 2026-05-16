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
            ['name' => 'Entrées',          'icon' => '🥗', 'description' => 'Verrines, terrines, crudités et amuse-bouches pour ouvrir l\'appétit'],
            ['name' => 'Soupes & Veloutés','icon' => '🍲', 'description' => 'Potages maison, bisques, gaspachos et bouillons réconfortants'],
            ['name' => 'Plats de viande',  'icon' => '🥩', 'description' => 'Rôtis, braisés, grillades et mijotés à base de bœuf, volaille ou agneau'],
            ['name' => 'Plats de poisson', 'icon' => '🐟', 'description' => 'Filets, pavés, fruits de mer et gratins de la mer'],
            ['name' => 'Plats végétariens','icon' => '🥦', 'description' => 'Tartes, currys, risottos et plats sans viande ni poisson'],
            ['name' => 'Pâtes & Riz',      'icon' => '🍝', 'description' => 'Pâtes fraîches, sèches, risottos, pilaffs et nouilles du monde'],
            ['name' => 'Pizza & Tartes',   'icon' => '🍕', 'description' => 'Pizzas maison, quiches, flamekuches et tartes salées'],
            ['name' => 'Salades',          'icon' => '🥙', 'description' => 'Salades composées, tièdes ou fraîches pour toutes les saisons'],
            ['name' => 'Desserts',         'icon' => '🍰', 'description' => 'Gâteaux, tartes, mousses, crèmes et douceurs sucrées'],
            ['name' => 'Pâtisserie',       'icon' => '🥐', 'description' => 'Macarons, éclairs, choux, millefeuilles et viennoiseries'],
            ['name' => 'Pain & Boulangerie','icon' => '🍞', 'description' => 'Pains maison, brioches, focaccias et pains du monde'],
            ['name' => 'Petit déjeuner',   'icon' => '🍳', 'description' => 'Pancakes, granolas, œufs cocotte et recettes du matin'],
            ['name' => 'Snacks & Apéro',   'icon' => '🧀', 'description' => 'Tapas, dips, crackers, brochettes et bouchées apéritives'],
            ['name' => 'Boissons',         'icon' => '🥤', 'description' => 'Smoothies, jus frais, laits végétaux, infusions et cocktails sans alcool'],
            ['name' => 'Sauces & Condiments','icon' => '🫙', 'description' => 'Sauces maison, vinaigrettes, marinades, pestos et condiments'],
            ['name' => 'Cuisine du monde', 'icon' => '🌍', 'description' => 'Recettes japonaises, mexicaines, indiennes, libanaises et bien plus'],
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
