<?php

namespace App\Services;

use App\Models\User;

class MilestoneService
{
    public static function handle(User $user): ?int
    {
        if (!in_array($user->current_streak, GameSettings::milestones())) {
            return null;
        }

        XpService::award($user, 'milestone', "Milestone {$user->current_streak} hari! 🎉");

        self::awardBadge($user);

        return $user->current_streak;
    }

    private static function awardBadge(User $user): void
    {
        $badge = \App\Models\Badge::where('required_streak', $user->current_streak)->first();

        if ($badge && !$user->badges->contains($badge->id)) {
            $user->badges()->attach($badge->id, ['earned_at' => now()]);
            session()->flash('new_badge', [
                'icon'        => $badge->icon,
                'name'        => $badge->name,
                'description' => $badge->description,
            ]);
        }
    }
}