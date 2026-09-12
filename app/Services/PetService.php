<?php

namespace App\Services;

use App\Models\Pet;
use App\Models\User;

class PetService
{
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
        foreach (GameSettings::milestones() as $m) {
            if ($streak >= $m) {
                $stage = $m;
            }
        }
        return $stage;
    }

    /** Pastiin user punya pet — kalau belum, bikin telur baru */
    public static function ensure(User $user): Pet
    {
        return $user->pet ?? Pet::create(['user_id' => $user->id]);
    }

    /** Evolve kalau stage baru > stage sekarang */
    public static function evolveIfNeeded(User $user, Pet $pet): void
    {
        $newStage = self::stageFor($user->current_streak);
        if ($newStage > $pet->stage) {
            $pet->update(['stage' => $newStage, 'status' => 'alive']);
        }
    }
}