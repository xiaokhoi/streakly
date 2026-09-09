<?php

namespace App\Models;

use App\Services\StreakService;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $fillable = ['user_id', 'stage', 'status'];

    public function emoji(): string
    {
        return StreakService::PET_STAGES[$this->stage] ?? '🥚';
    }
}