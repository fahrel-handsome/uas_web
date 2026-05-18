<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\UserProgress;
use App\Services\ModuleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ModuleController extends Controller
{
    public function __construct(
        private readonly ModuleService $moduleService
    ) {}

    public function index(): View
    {
        $modules = $this->moduleService->getAllPublished();
        return view('modules.index', compact('modules'));
    }

    /**
     * GATEKEEPER: Enforce pre-test completion before accessing module content.
     *
     * Rules (Belajar Langkah demi Langkah):
     * 1. Guest users → redirect to login
     * 2. Auth users without pre-test score → redirect to pre-test
     * 3. Auth users with pre-test score → allow access
     */
    public function show(Module $module): View|RedirectResponse
    {
        // Guest → must login first
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('warning', 'Silakan masuk terlebih dahulu untuk mengakses modul.');
        }

        // Check pre-test status for this module
        // We look for any UserProgress record linked to courses in this module
        // that has a score_pre_test value set.
        $preTestDone = UserProgress::where('user_id', auth()->id())
            ->where('module_id', $module->id)
            ->whereNotNull('score_pre_test')
            ->exists();

        // Fallback: check via quiz answers for pre_test type quizzes in this module
        if (!$preTestDone) {
            $preTestDone = \App\Models\UserQuizAnswer::where('user_id', auth()->id())
                ->whereHas('quiz', function ($q) use ($module) {
                    $q->where('type', 'pre_test')
                      ->whereHas('course', fn($c) => $c->where('module_id', $module->id));
                })
                ->exists();
        }

        if (!$preTestDone) {
            return redirect()->route('modules.pre-test', $module)
                ->with('warning', 'Anda harus menyelesaikan Pre-test terlebih dahulu!');
        }

        // Load courses with progress for this user
        $module->load(['courses' => fn($q) => $q->where('is_published', true)->orderBy('order')]);

        $userProgress = UserProgress::where('user_id', auth()->id())
            ->whereIn('course_id', $module->courses->pluck('id'))
            ->get()
            ->keyBy('course_id');

        // Post-test status
        $postTestDone = \App\Models\UserQuizAnswer::where('user_id', auth()->id())
            ->whereHas('quiz', function ($q) use ($module) {
                $q->where('type', 'post_test')
                  ->whereHas('course', fn($c) => $c->where('module_id', $module->id));
            })
            ->exists();

        return view('modules.show', compact('module', 'userProgress', 'postTestDone'));
    }
}
