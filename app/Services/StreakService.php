<?php

namespace App\Services;

use App\Models\CheckIn;
use App\Models\Pet;
use App\Models\User;
use App\Services\XpService;
use Carbon\Carbon;

class StreakService
{
    public const MILESTONES = [1, 7, 14, 30, 100, 365];

    public const PET_STAGES = [
        0   => '🥚',
        1   => '🐣',
        7   => '🐥',
        14  => '🐤',
        30  => '🦅',
        100 => '🐲',
        365 => '🐉',
    ];

    public static function stageFor(int $streak): int
    {
        $stage = 0;
        foreach (self::MILESTONES as $m) {
            if ($streak >= $m) {
                $stage = $m;
            }
        }
        return $stage;
    }

    public static function refresh(User $user): void
    {
        if ($user->recovery_month !== now()->format('Y-m')) {
            $user->update([
                'recovery_month'  => now()->format('Y-m'),
                'recovery_tokens' => 3,
            ]);
        }

        $pet = $user->pet ?? Pet::create(['user_id' => $user->id]);

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

    public static function checkIn(User $user, ?string $note = null, ?int $habitId = null): ?int
    {
        $pet = $user->pet;

        if ($pet?->status === 'fainted') {
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

        $newStage = self::stageFor($user->current_streak);
        if ($newStage > $pet->stage) {
            $pet->update(['stage' => $newStage, 'status' => 'alive']);
        }

                // ===== XP =====
        XpService::award($user, $habitId ? 'checkin_habit' : 'checkin_app', "Check-in hari ke-{$user->current_streak}");

        if (in_array($user->current_streak, self::MILESTONES)) {
            XpService::award($user, 'milestone', "Milestone {$user->current_streak} hari! 🎉");

            // ===== BADGE =====
            $badge = \App\Models\Badge::where('required_streak', $user->current_streak)->first();
            if ($badge && !$user->badges->contains($badge->id)) {
                $user->badges()->attach($badge->id, ['earned_at' => now()]);
                session()->flash('new_badge', $badge);
            }

            return $user->current_streak;
        }

        return null;
    }
}