<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Module extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'youtube_link',
        'status',
        'icon',
        'order',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    // ─── Relationships ─────────────────────────────────────
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    // ─── Accessors ─────────────────────────────────────────

    /**
     * Extract YouTube video ID from any YouTube URL format.
     * Supports: youtube.com/watch?v=ID, youtu.be/ID, youtube.com/embed/ID
     */
    public function getYoutubeIdAttribute(): ?string
    {
        if (!$this->youtube_link) return null;

        preg_match(
            '/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/',
            $this->youtube_link,
            $matches
        );

        return $matches[1] ?? null;
    }

    /**
     * Return ready-to-use embed URL for iframe.
     * Example: https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ
     */
    public function getYoutubeEmbedUrlAttribute(): ?string
    {
        $id = $this->youtube_id;
        return $id ? "https://www.youtube-nocookie.com/embed/{$id}?rel=0&modestbranding=1" : null;
    }

    /**
     * Return YouTube thumbnail URL.
     */
    public function getYoutubeThumbnailAttribute(): ?string
    {
        $id = $this->youtube_id;
        return $id ? "https://img.youtube.com/vi/{$id}/mqdefault.jpg" : null;
    }

    // ─── Scopes ────────────────────────────────────────────
    public function scopePublished($query)
    {
        return $query->where('is_published', true)->where('status', 'published');
    }
}
