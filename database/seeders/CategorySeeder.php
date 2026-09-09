<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Kesehatan',      'icon' => '💪'],
            ['name' => 'Olahraga',       'icon' => '🏃'],
            ['name' => 'Belajar',        'icon' => '📚'],
            ['name' => 'Produktivitas',  'icon' => '⚡'],
            ['name' => 'Keuangan',       'icon' => '💰'],
            ['name' => 'Spiritual',      'icon' => '🕌'],
            ['name' => 'Kreatif',        'icon' => '🎨'],
            ['name' => 'Sosial',         'icon' => '🤝'],
        ];

        DB::table('categories')->insert($categories);
    }
}