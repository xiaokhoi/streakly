<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StreakGrave extends Model
{
    protected $fillable = ['user_id', 'length', 'died_at', 'cause'];

    protected function casts(): array
    {
        return [
            'died_at' => 'date',
        ];
    }

    /** epitap random — biar makamnya kerasa hidup 😄 */
    public function epitaph(): string
    {
        $epitaphs = [
            'Di sini terkubur semangat yang dulu menyala 🔥',
            'Ia pernah konsisten. Sekali waktu.',
            'Meninggalkan dunia dengan tangan hampa (gak check-in)',
            'Pet-nya masih inget jasa-jasanya',
            'Mati karena dilupain. Rip.',
            'Streak terbaiknya belum tentu yang ini',
            'Kalau aja dia buka app hari itu...',
            'Gugur di medan perang melawan rasa malas',
        ];

        return $epitaphs[array_rand($epitaphs)];
    }
}