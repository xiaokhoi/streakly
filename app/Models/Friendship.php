<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Friendship extends Model
{
    protected $fillable = [
        'user_id',
        'friend_id',
        'status',
        'type',
        'streak_count',
        'last_mutual_date',
    ];

    protected function casts(): array
    {
        return [
            'last_mutual_date' => 'date',
        ];
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

        public function partner()
    {
        return $this->belongsTo(User::class, 'friend_id');
    }

        public function messages()
    {
        return $this->hasMany(Message::class, 'friendship_id')->orderBy('sent_at');
    }

    public function lastMessage()
    {
        return $this->hasOne(Message::class, 'friendship_id')->orderByDesc('id');
    }

    public function scopeWithLastMessageFor($query, User $user)
    {
        return $query->with(['lastMessage.sender']);
    }

    public static function TYPES(): array
    {
        return [
            'sahabat'  => '🤝',
            'pacar'    => '💞',
            'keluarga' => '👨‍👩‍👦',
            'gym'      => '💪',
        ];
    }
}