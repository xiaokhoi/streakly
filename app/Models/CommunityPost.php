<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityPost extends Model
{
    protected $fillable = ['user_id', 'category_id', 'title', 'body'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class, 'post_id');
    }

    public function votes()
    {
        return $this->hasMany(PostVote::class, 'post_id');
    }

    public function upvotes()
    {
        return $this->votes()->where('value', 1);
    }

    public function downvotes()
    {
        return $this->votes()->where('value', -1);
    }

    public function score(): int
    {
        return $this->upvotes()->count() - $this->downvotes()->count();
    }

    public function myVote()
    {
        return $this->votes()->where('user_id', auth()->id())->value('value');
    }
}