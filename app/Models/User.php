<?php

namespace App\Models;

use App\Models\Friendship;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'current_streak',
        'longest_streak',
        'last_check_in',
        'recovery_tokens',
        'recovery_month',
        'xp',
        'level',
        'badge_id',
        'avatar',
        
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_check_in' => 'date',
        ];
    }

    public function pet(): HasOne
    {
        return $this->hasOne(Pet::class);
    }

        public function habits(): HasMany
    {
        return $this->hasMany(Habit::class);
    }

        public function badges()
    {
        return $this->belongsToMany(Badge::class)->withPivot('earned_at');
    }

        public function title()
    {
        return $this->belongsTo(Badge::class, 'badge_id');
    }

        public function friendships()
    {
        return Friendship::query()
            ->where(fn ($q) => $q->where('user_id', $this->id)
                ->orWhere('friend_id', $this->id));
    }

    public function hasStreakInDanger(): bool
    {
        return $this->friendships()
            ->where('status', 'accepted')
            ->where('streak_count', '>', 0)
            ->where(function ($q) {
                $q->whereNull('last_mutual_date')
                  ->orWhereDate('last_mutual_date', '!=', today());
            })
            ->exists();
    }


    public function xpForNextLevel(): int
    {
        return $this->level * 100;
    }

    public function xpProgress(): int
    {
        return min(100, (int) (($this->xp / $this->xpForNextLevel()) * 100));
    }
}