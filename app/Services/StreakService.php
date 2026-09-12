<?php

namespace App\Services;

use App\Models\CheckIn;
use App\Models\User;

class StreakService
{
    /** Pintu utama check-in (app atau habit). Return milestone kalau baru tercapai. */
    public static function checkIn(User $user, ?string $note = null, ?int $habitId = null): ?int
    {
        $pet = PetService::ensure($user);

        if ($pet->status === 'fainted') {
            return null;
        }

        $alreadyToday = $user->last_check_in && $user->last_check_in->isToday();

        if ($alreadyToday && is_null($habitId)) {
            return null;
        }

        CheckIn::create([
            'user_id'    => $user->id,
            'habit_id'   => $habitId,
            'checked_at' => now(),
            'note'       => $note,
        ]);

        if ($alreadyToday) {
            return null;
        }

        if ($user->last_check_in && $user->last_check_in->isYesterday()) {
            $user->current_streak++;
        } else {
            $user->current_streak = 1;
        }

        $user->longest_streak = max($user->longest_streak, $user->current_streak);
        $user->last_check_in  = today();
        $user->save();

        PetService::evolveIfNeeded($user, $pet);

        XpService::award($user, $habitId ? 'checkin_habit' : 'checkin_app', "Check-in hari ke-{$user->current_streak}");

        $milestone = MilestoneService::handle($user);

        return $milestone ?? null;
    }

    /** Hari berat: hadir versi minimum — streak aman, TANPA makan recovery token */
    public static function hardDay(User $user): bool
    {
        if (!$user->canUseHardDay()) {
            return false;
        }

        $alreadyToday = $user->last_check_in && $user->last_check_in->isToday();

        CheckIn::create([
            'user_id'    => $user->id,
            'habit_id'   => null,
            'checked_at' => now(),
            'note'       => '🫂 hari berat — tapi aku tetep dateng',
        ]);

        if (!$alreadyToday) {
            if ($user->last_check_in && $user->last_check_in->isYesterday()) {
                $user->current_streak++;
            } else {
                $user->current_streak = 1;
            }

            $user->longest_streak = max($user->longest_streak, $user->current_streak);
            $user->last_check_in  = today();
            $user->save();

            XpService::award($user, 'checkin_app', "Hari berat — tetep hadir (streak {$user->current_streak})");
        }

        $user->increment('hard_days_used');

        return true;
    }

    // ===== delegasi: signature lama tetep jalan, controller gak perlu diubah =====

    public static function refresh(User $user): void
    {
        RecoveryService::refresh($user);
    }

    public static function recover(User $user): bool
    {
        return RecoveryService::recover($user);
    }
}