<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = ['user_id', 'post_id', 'comment_id', 'reason'];

    public function post()
    {
        return $this->belongsTo(CommunityPost::class);
    }

    public function comment()
    {
        return $this->belongsTo(PostComment::class);
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}