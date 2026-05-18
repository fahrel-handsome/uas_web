<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserPoints;

/**
 * GamificationService
 *
 * Manages user points, levels, and badges.
 * Levels: Pemula → Pelajar → Mahir → Expert → Master
 */
class GamificationService
{
    // ─── Point Rules ───────────────────────────────────────
    private const POINT_RULES = [
        'lesson_complete' => 10,
        'quiz_pass'       => 50,
        'post_test_pass'  => 75,
        'certificate'     => 100,
        'forum_post'      => 5,
        'forum_comment'   => 3,
        'daily_streak'    => 5,
    ];

    // ─── Level Thresholds ──────────────────────────────────
    public const LEVELS = [
        ['min' => 0,    'max' => 99,   'label' => 'Pemula',   'badge' => 'Beginner',     'rank' => 5],
        ['min' => 100,  'max' => 299,  'label' => 'Pelajar',  'badge' => 'Learner',      'rank' => 4],
        ['min' => 300,  'max' => 699,  'label' => 'Mahir',    'badge' => 'Intermediate', 'rank' => 3],
        ['min' => 700,  'max' => 1499, 'label' => 'Expert',   'badge' => 'Expert',       'rank' => 2],
        ['min' => 1500, 'max' => PHP_INT_MAX, 'label' => 'Master', 'badge' => 'Master',  'rank' => 1],
    ];

    // ─── Public Methods ────────────────────────────────────

    /**
     * Award points for a specific action.
     */
    public function awardPoints(User $user, string $action, ?int $override = null): void
    {
        $user->ensureUserPointsExist();

        $points = $override ?? (self::POINT_RULES[$action] ?? 0);
        if ($points <= 0) return;

        $userPoints = $user->userPoints()->lockForUpdate()->first();
        if (!$userPoints) return;

        $userPoints->total_points += $points;

        // Sync level data
        $level = $this->getLevelForPoints($userPoints->total_points);
        $userPoints->badge = $level['badge'];
        $userPoints->rank  = $level['rank'];
        $userPoints->save();

        // Update user level column
        $user->update(['level' => $level['label']]);
    }

    /**
     * Update user level based on current total points.
     * Call after any point change to keep user.level in sync.
     */
    public function updateLevel(User $user): void
    {
        $user->ensureUserPointsExist();
        $userPoints = $user->userPoints;

        if (!$userPoints) return;

        $level = $this->getLevelForPoints($userPoints->total_points);

        $userPoints->update(['badge' => $level['badge'], 'rank' => $level['rank']]);

        // Update level column on users table if it exists
        if (array_key_exists('level', $user->getAttributes()) || $user->isFillable('level')) {
            $user->update(['level' => $level['label']]);
        }
    }

    /**
     * Get level info for a given points total.
     */
    public function getLevelForPoints(int $points): array
    {
        foreach (self::LEVELS as $level) {
            if ($points >= $level['min'] && $points <= $level['max']) {
                return $level;
            }
        }
        return end(self::LEVELS);
    }

    public function getLevelLabel(int $points): string
    {
        return $this->getLevelForPoints($points)['label'];
    }

    public function getProgressToNextLevel(int $points): array
    {
        $current = $this->getLevelForPoints($points);
        $currentIndex = array_search($current, self::LEVELS);
        $nextIndex = $currentIndex + 1;

        if ($nextIndex >= count(self::LEVELS)) {
            return ['current' => $current, 'next' => null, 'progress' => 100, 'needed' => 0];
        }

        $next         = self::LEVELS[$nextIndex];
        $range        = $next['min'] - $current['min'];
        $progress     = max(0, $points - $current['min']);
        $progressPct  = $range > 0 ? min(100, (int) round(($progress / $range) * 100)) : 100;
        $needed       = max(0, $next['min'] - $points);

        return [
            'current'     => $current,
            'next'        => $next,
            'progress'    => $progressPct,
            'needed'      => $needed,
        ];
    }
}
