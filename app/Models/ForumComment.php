<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ForumComment extends Model
{
    protected $table = 'forum_comments';
    protected $fillable = ['forum_post_id', 'user_id', 'content', 'is_helpful'];

    public function post(): BelongsTo
    {
        return $this->belongsTo(ForumPost::class, 'forum_post_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function incrementLikes()
    {
        $this->increment('likes_count');
    }
}
