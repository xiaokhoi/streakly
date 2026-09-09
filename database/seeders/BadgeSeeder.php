<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BadgeSeeder extends Seeder
{
    public function run(): void
    {
        $badges = [
            ['name' => 'Langkah Pertama',      'icon' => '🌱', 'description' => 'Mulai perjalanan: streak 1 hari',      'required_streak' => 1],
            ['name' => 'Konsisten Sepekan',    'icon' => '🔥', 'description' => 'Streak 7 hari berturut-turut',         'required_streak' => 7],
            ['name' => 'Dua Pekan Tanpa Henti','icon' => '⚡', 'description' => 'Streak 14 hari berturut-turut',        'required_streak' => 14],
            ['name' => 'Penguasa Bulan',       'icon' => '👑', 'description' => 'Streak 30 hari — jarang ada yang sampe sini', 'required_streak' => 30],
            ['name' => 'Legend 100 Hari',      'icon' => '💎', 'description' => 'Streak 100 hari. Kamu bukan orang biasa',     'required_streak' => 100],
            ['name' => 'Immortal',             'icon' => '🐉', 'description' => 'Streak 1 tahun penuh. Respek.',               'required_streak' => 365],
        ];

        DB::table('badges')->insert($badges);
    }
}