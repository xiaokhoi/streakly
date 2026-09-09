<?php

namespace App\Services;

use App\Models\User;
use App\Models\XpEvent;

class XpService
{
    public const REWARDS = [
        'checkin_app'      => 10,
        'checkin_habit'    => 5,
        'milestone'        => 50,
    ];

    public static function award(User $user, string $source, ?string $description = null): void
    {
        $amount = self::REWARDS[$source] ?? 0;

        if ($amount === 0) {
            return;
        }

        XpEvent::create([
            'user_id'     => $user->id,
            'amount'      => $amount,
            'source'      => $source,
            'description' => $description,
        ]);

        $user->xp += $amount;

        $newLevel = 1;
        $remaining = $user->xp;
        while ($remaining >= $newLevel * 100) {
            $remaining -= $newLevel * 100;
            $newLevel++;
        }

        if ($newLevel > $user->level) {
            session()->flash('level_up', $newLevel);
        }

        $user->level = $newLevel;
        $user->save();
    }
}