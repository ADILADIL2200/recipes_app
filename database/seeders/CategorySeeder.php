<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Technology',
                'slug' => Str::slug('Technology'),
                'description' => 'All tech related topics',
                'icon' => 'tech-icon.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sports',
                'slug' => Str::slug('Sports'),
                'description' => 'Sports news and updates',
                'icon' => 'sports-icon.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Health',
                'slug' => Str::slug('Health'),
                'description' => 'Health and wellness',
                'icon' => 'health-icon.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}