<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tags')->insert([
            [
                'name' => 'Laravel',
                'slug' => Str::slug('Laravel'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'JavaScript',
                'slug' => Str::slug('JavaScript'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'PHP',
                'slug' => Str::slug('PHP'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'React',
                'slug' => Str::slug('React'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}