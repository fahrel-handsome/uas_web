<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Module;
use App\Models\UserProgress;
use App\Models\UserQuizAnswer;
use App\Services\GamificationService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private readonly GamificationService $gamificationService
    ) {}

    public function index(): View
    {
        $user = auth()->user();
        $user->ensureUserPointsExist();

        // ─── Basic Stats ───────────────────────────────
        $enrolledCourses  = UserProgress::where('user_id', $user->id)
            ->with('course.module')
            ->get();

        $completedCourses = $enrolledCourses->where('is_completed', true)->count();
        $certificates     = Certificate::where('user_id', $user->id)->count();
        $userPoints       = $user->userPoints;

        // ─── Module Progress (for pre/post-test chart) ─
        $moduleProgress = UserProgress::where('user_id', $user->id)
            ->with('course.module')
            ->whereNotNull('module_id')
            ->get();

        // ─── Chart.js Data — Skor Pre-test vs Post-test ─
        // Format: [{module, pre, post}, ...] for Chart.js
        $chartData = Module::whereIn('id', $moduleProgress->pluck('module_id')->filter())
            ->get()
            ->map(function (Module $module) use ($moduleProgress) {
                $progress = $moduleProgress->firstWhere('module_id', $module->id);
                return [
                    'module'    => \Illuminate\Support\Str::limit($module->title, 20),
                    'pre_test'  => $progress?->score_pre_test  ?? null,
                    'post_test' => $progress?->score_post_test ?? null,
                ];
            })
            ->filter(fn($d) => $d['pre_test'] !== null)
            ->values();

        // ─── Recent Quiz Activity ──────────────────────
        $recentActivity = UserQuizAnswer::where('user_id', $user->id)
            ->with('quiz.course.module')
            ->orderByDesc('completed_at')
            ->limit(5)
            ->get();

        // ─── Level/Gamification Info ───────────────────
        $totalPoints   = $userPoints?->total_points ?? 0;
        $levelProgress = $this->gamificationService->getProgressToNextLevel($totalPoints);
        $levelLabel    = $this->gamificationService->getLevelLabel($totalPoints);

        return view('dashboard', [
            'enrolledCourses'  => $enrolledCourses,
            'completedCourses' => $completedCourses,
            'certificates'     => $certificates,
            'userPoints'       => $userPoints,
            'chartData'        => $chartData,         // JSON for Chart.js
            'recentActivity'   => $recentActivity,
            'levelProgress'    => $levelProgress,
            'levelLabel'       => $levelLabel,
            'totalPoints'      => $totalPoints,
        ]);
    }
}
