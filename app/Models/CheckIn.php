<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckIn extends Model
{
    protected $fillable = ['user_id', 'habit_id', 'checked_at', 'note'];

    public function habit()
    {
        return $this->belongsTo(Habit::class);
    }
}