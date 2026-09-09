<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    protected $fillable = ['name', 'icon', 'description', 'required_streak'];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('earned_at');
    }
}