<?php

namespace App\Services;

use App\Models\Pet;
use App\Models\User;
use Carbon\Carbon;

class RecoveryService
{
    public static function refresh(User $user): void
    {
        $tokenLimit = GameSettings::recoveryTokens();

        if ($user->recovery_month !== now()->format('Y-m')) {
            $user->update([
                'recovery_month'  => now()->format('Y-m'),
                'recovery_tokens' => $tokenLimit,
            ]);
        }

        $hardLimit = GameSettings::hardDaysLimit();

        if ($user->hard_days_month !== now()->format('Y-m')) {
            $user->update([
                'hard_days_month' => now()->format('Y-m'),
                'hard_days_used'  => 0,
            ]);
        }

        $pet = PetService::ensure($user);

        if (!$user->last_check_in || $user->current_streak === 0) {
            return;
        }

        $gap = Carbon::parse($user->last_check_in)->diffInDays(today());

        if ($gap === 1) {
            if ($user->recovery_tokens > 0) {
                $pet->update(['status' => 'fainted']);
            } else {
                self::hangus($user, $pet);
            }
        } elseif ($gap >= 2) {
            self::hangus($user, $pet);
        }
    }

    public static function hangus(User $user, Pet $pet): void
    {
        if ($user->current_streak > 0) {
            \App\Models\StreakGrave::create([
                'user_id' => $user->id,
                'length'  => $user->current_streak,
                'died_at' => today(),
                'cause'   => 'bolong',
            ]);
        }

        $user->letters()->whereNull('opened_at')->update(['opened_at' => now()]);

        $user->update(['current_streak' => 0]);
        $pet->update(['stage' => 0, 'status' => 'alive']);
    }

    public static function recover(User $user): bool
    {
        $pet = $user->pet;

        if (!$pet || $pet->status !== 'fainted' || $user->recovery_tokens < 1) {
            return false;
        }

        $user->decrement('recovery_tokens');
        $pet->update(['status' => 'alive']);

        return true;
    }
}