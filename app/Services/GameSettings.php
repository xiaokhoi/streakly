<?php

namespace App\Services;

use App\Models\Setting;

class GameSettings
{
    /** DEFINISI semua setting: key => [label, default, tipe] */
    public const DEFS = [
        'recovery_tokens'      => ['Jumlah recovery token per bulan', '3', 'int'],
        'hard_days_limit'      => ['Kuota hari berat per bulan', '2', 'int'],
        'chat_streak_miss_days'=> ['Hari bolong chat sebelum streak bareng hangus', '1', 'int'],
        'xp_checkin_app'       => ['XP check-in aplikasi', '10', 'int'],
        'xp_checkin_habit'     => ['XP centang habit', '5', 'int'],
        'xp_milestone'         => ['XP bonus milestone', '50', 'int'],
        'milestones'           => ['Milestone streak (pisah koma)', '1,7,14,30,100,365', 'list'],
    ];

    public static function get(string $key)
    {
        $def = self::DEFS[$key] ?? null;
        $default = $def[1] ?? null;

        $raw = Setting::get($key, $default);

        return match ($def[2] ?? 'string') {
            'int'  => (int) $raw,
            'list' => collect(explode(',', (string) $raw))->map(fn ($v) => (int) trim($v))->filter()->values()->toArray(),
            default => $raw,
        };
    }

    // ===== shortcut yang dipakai service =====

    public static function recoveryTokens(): int   { return self::get('recovery_tokens'); }
    public static function hardDaysLimit(): int    { return self::get('hard_days_limit'); }
    public static function chatMissDays(): int     { return self::get('chat_streak_miss_days'); }
    public static function milestones(): array     { return self::get('milestones'); }
}