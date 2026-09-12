<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    protected $fillable = ['user_id', 'post_id', 'parent_id', 'body'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** balasan dari komentar ini (1 tingkat) */
    public function replies()
    {
        return $this->hasMany(PostComment::class, 'parent_id')->orderBy('created_at');
    }

    public function reactions()
    {
        return $this->hasMany(CommentReaction::class, 'comment_id');
    }

    public function fireCount(): int
    {
        return $this->reactions()->count();
    }

    /** lu udah kasih 🔥 di komentar ini? */
    public function myFire(): bool
    {
        return $this->reactions()->where('user_id', auth()->id())->exists();
    }
}