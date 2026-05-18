<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    protected $fillable = ['course_id', 'title', 'slug', 'content', 'video_url', 'duration_minutes', 'order', 'is_published'];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function completedByUsers(): HasMany
    {
        return $this->hasMany(CompletedLesson::class);
    }
}
