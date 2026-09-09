<?php

namespace App\Services;

use App\Models\Friendship;
use Carbon\Carbon;

class ChatStreakService
{
    /** Dipanggil SETIAP pesan terkirim. Cek: kedua orang udah chat hari ini? */
    public static function onMessage(Friendship $friendship): void
    {
        if ($friendship->status !== 'accepted') {
            return;
        }

        $today = today()->toDateString();

        // ⚠️ last_mutual_date itu objek Carbon (karena casts) — WAJIB diubah ke string dulu
        $lastMutualDate = $friendship->last_mutual_date?->toDateString();

        // udah dihitung hari ini? jangan dobel (anti-spam)
        if ($lastMutualDate === $today) {
            return;
        }

        // kapan terakhir KEDUA orang ngirim pesan?
        $bothDates = $friendship->messages()
            ->selectRaw('DATE(sent_at) as day, sender_id')
            ->whereIn('sender_id', [$friendship->user_id, $friendship->friend_id])
            ->get()
            ->groupBy('day')
            ->filter(fn ($msgs) => $msgs->pluck('sender_id')->unique()->count() === 2)
            ->keys();

        $lastMutual = $bothDates->sortDesc()->first();

        if (!$lastMutual || $lastMutual !== $today) {
            return; // belum saling chat hari ini — streak belum sah
        }

        // bolong >= 2 hari? reset dulu, streak mulai dari 1 lagi
        if ($lastMutualDate && Carbon::parse($lastMutualDate)->diffInDays(today()) >= 2) {
            $friendship->update(['streak_count' => 0]);
        }

        $friendship->increment('streak_count');
        $friendship->update(['last_mutual_date' => $today]);
    }
}