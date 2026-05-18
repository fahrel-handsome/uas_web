<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserQuizAnswer extends Model
{
    protected $table = 'user_quiz_answers';
    protected $fillable = ['user_id', 'quiz_id', 'score', 'answers', 'passed', 'completed_at'];

    protected $casts = [
        'answers' => 'array',
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }
}
