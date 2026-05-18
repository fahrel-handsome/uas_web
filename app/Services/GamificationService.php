<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserPoints;

class GamificationService
{
    private const POINT_RULES = [
        'lesson_complete' => 10,
        'quiz_pass'       => 50,
        'post_test_pass'  => 75,
        'certificate'     => 100,
        'forum_post'      => 5,
        'forum_comment'   => 3,
        'daily_streak'    => 5,
    ];

    private const LEVELS = [
        ['min' => 0,   'max' => 100, 'label' => 'Pemula',  'badge' => 'Beginner'],
        ['min' => 101, 'max' => 300, 'label' => 'Pelajar', 'badge' => 'Learner'],
        ['min' => 301, 'max' => 700, 'label' => 'Mahir',   'badge' => 'Intermediate'],
        ['min' => 701, 'max' => PHP_INT_MAX, 'label' => 'Expert', 'badge' => 'Expert'],
    ];

    public function awardPoints(User $user, string $action, ?int $override = null): void
    {
        $user->ensureUserPointsExist();

        $points = $override ?? (self::POINT_RULES[$action] ?? 0);
        if ($points <= 0) return;

        $userPoints = $user->userPoints;
        $userPoints->addPoints($points);

        // Update level/badge
        $newTotal = $userPoints->fresh()->total_points;
        $level = $this->getLevel($newTotal);
        $userPoints->update(['rank' => $this->getLevelRank($newTotal), 'badge' => $level['badge']]);
    }

    public function getLevel(int $points): array
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
        return $this->getLevel($points)['label'];
    }

    private function getLevelRank(int $points): int
    {
        foreach (self::LEVELS as $i => $level) {
            if ($points >= $level['min'] && $points <= $level['max']) {
                return $i + 1;
            }
        }
        return count(self::LEVELS);
    }
}
