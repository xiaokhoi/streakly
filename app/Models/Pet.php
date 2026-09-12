<?php

namespace App\Models;

use App\Services\PetService;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $fillable = ['user_id', 'stage', 'status'];

    public function emoji(): string
    {
        return PetService::PET_STAGES[$this->stage] ?? '🥚';
    }
}