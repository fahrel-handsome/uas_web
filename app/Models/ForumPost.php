<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ForumPost extends Model
{
    protected $table = 'forum_posts';

    protected $fillable = [
        'forum_category_id',
        'user_id',
        'title',
        'slug',
        'content',
        'is_pinned',
        'is_closed',
        'views_count',
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
        'is_closed' => 'boolean',
    ];

    // ─── Relationships ─────────────────────────────────────
    public function category(): BelongsTo
    {
        return $this->belongsTo(ForumCategory::class, 'forum_category_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(ForumComment::class);
    }

    // ─── Methods ───────────────────────────────────────────
    public function incrementViews(): void
    {
        $this->increment('views_count');
    }
}
