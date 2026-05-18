<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProgress extends Model
{
    protected $table = 'user_progress';
    protected $fillable = ['user_id', 'course_id', 'completed_lessons', 'total_lessons', 'progress_percentage', 'is_completed', 'completed_at'];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function updateProgress()
    {
        $this->progress_percentage = ($this->completed_lessons / $this->total_lessons) * 100;
        if ($this->completed_lessons === $this->total_lessons) {
            $this->is_completed = true;
            $this->completed_at = now();
        }
        $this->save();
    }
}
