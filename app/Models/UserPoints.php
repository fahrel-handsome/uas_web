<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPoints extends Model
{
    protected $table = 'user_points';
    protected $fillable = ['user_id', 'total_points', 'rank', 'badge'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function addPoints($points)
    {
        $this->total_points += $points;
        $this->updateRank();
        $this->save();
    }

    public function updateRank()
    {
        if ($this->total_points >= 1000) {
            $this->badge = 'Master';
            $this->rank = 1;
        } elseif ($this->total_points >= 500) {
            $this->badge = 'Expert';
            $this->rank = 2;
        } elseif ($this->total_points >= 100) {
            $this->badge = 'Intermediate';
            $this->rank = 3;
        } else {
            $this->badge = 'Beginner';
            $this->rank = 4;
        }
    }
}
