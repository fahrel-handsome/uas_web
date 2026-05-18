<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProgress extends Model
{
    protected $table = 'user_progress';

    protected $fillable = [
        'user_id',
        'course_id',
        'module_id',
        'completed_lessons',
        'total_lessons',
        'progress_percentage',
        'is_completed',
        'completed_at',
        'score_pre_test',
        'score_post_test',
        'module_status',
    ];

    protected $casts = [
        'completed_at'  => 'datetime',
        'is_completed'  => 'boolean',
        'score_pre_test'  => 'integer',
        'score_post_test' => 'integer',
    ];

    // ─── Relationships ─────────────────────────────────────
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    // ─── Business Logic ────────────────────────────────────

    public function updateProgress(): void
    {
        if ($this->total_lessons > 0) {
            $this->progress_percentage = round(
                ($this->completed_lessons / $this->total_lessons) * 100
            );
        }

        if ($this->completed_lessons >= $this->total_lessons && $this->total_lessons > 0) {
            $this->is_completed   = true;
            $this->completed_at   = now();
            $this->module_status  = 'completed';
        }

        $this->save();
    }

    // ─── Accessors ─────────────────────────────────────────

    /**
     * Score improvement from pre to post test.
     */
    public function getScoreImprovementAttribute(): ?int
    {
        if ($this->score_pre_test === null || $this->score_post_test === null) {
            return null;
        }
        return $this->score_post_test - $this->score_pre_test;
    }
}
