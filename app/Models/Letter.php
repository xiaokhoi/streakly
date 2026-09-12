<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    protected $fillable = ['user_id', 'body', 'unlock_at_streak', 'written_at', 'opened_at'];

    protected function casts(): array
    {
        return [
            'written_at' => 'datetime',
            'opened_at'  => 'datetime',
        ];
    }

    public function isLocked(): bool
    {
        return $this->opened_at === null;
    }
}