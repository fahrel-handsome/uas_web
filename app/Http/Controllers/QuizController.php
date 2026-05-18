<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Module;
use App\Models\Quiz;
use App\Models\Course;
use App\Models\UserProgress;
use App\Models\UserQuizAnswer;
use App\Services\GamificationService;
use App\Services\QuizScoringService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuizController extends Controller
{
    public function __construct(
        private readonly QuizScoringService $scoringService,
        private readonly GamificationService $gamificationService
    ) {}

    // ─── Regular Quiz ──────────────────────────────────────

    public function show(Course $course, Quiz $quiz): View
    {
        if ($quiz->course_id !== $course->id) abort(404);
        $quiz->load('questions');
        return view('quizzes.show', compact('course', 'quiz'));
    }

    public function submit(Course $course, Quiz $quiz, Request $request): RedirectResponse
    {
        if (!auth()->check()) return redirect()->route('login');
        if ($quiz->course_id !== $course->id) abort(404);

        $quiz->load('questions');
        $answers = $request->input('answers', []);
        $result  = $this->scoringService->calculate($quiz, $answers);

        $quizAnswer = UserQuizAnswer::create([
            'user_id'      => auth()->id(),
            'quiz_id'      => $quiz->id,
            'score'        => $result['score'],
            'answers'      => $answers,
            'passed'       => $result['passed'],
            'completed_at' => now(),
        ]);

        if ($result['passed']) {
            $this->gamificationService->awardPoints(auth()->user(), 'quiz_pass');
            $this->issueCertificateIfEligible($course);
        }

        return redirect()->route('quizzes.result', [$course, $quiz, $quizAnswer->id]);
    }

    public function result(Course $course, Quiz $quiz, UserQuizAnswer $answer): View
    {
        if ($answer->quiz_id !== $quiz->id || $quiz->course_id !== $course->id) abort(404);
        if ($answer->user_id !== auth()->id()) abort(403);
        $quiz->load('questions');
        return view('quizzes.result', compact('course', 'quiz', 'answer'));
    }

    // ─── PRE-TEST ──────────────────────────────────────────

    public function preTest(Module $module): View
    {
        // If user already completed pre-test, show info
        $alreadyDone = UserQuizAnswer::where('user_id', auth()->id())
            ->whereHas('quiz', fn($q) => $q->where('type', 'pre_test')
                ->whereHas('course', fn($c) => $c->where('module_id', $module->id)))
            ->exists();

        $quiz = Quiz::where('type', 'pre_test')
            ->whereHas('course', fn($q) => $q->where('module_id', $module->id))
            ->with('questions')
            ->firstOrFail();

        return view('quizzes.pre-test', compact('module', 'quiz', 'alreadyDone'));
    }

    public function submitPreTest(Module $module, Request $request): RedirectResponse
    {
        $quiz = Quiz::where('type', 'pre_test')
            ->whereHas('course', fn($q) => $q->where('module_id', $module->id))
            ->with('questions')
            ->firstOrFail();

        $answers = $request->input('answers', []);
        $result  = $this->scoringService->calculate($quiz, $answers);

        // Save quiz answer
        UserQuizAnswer::create([
            'user_id'      => auth()->id(),
            'quiz_id'      => $quiz->id,
            'score'        => $result['score'],
            'answers'      => $answers,
            'passed'       => true, // pre-test always allows progression
            'completed_at' => now(),
        ]);

        // Save score_pre_test to user_progress (module-level)
        UserProgress::updateOrCreate(
            ['user_id' => auth()->id(), 'module_id' => $module->id],
            [
                'course_id'     => $quiz->course_id,
                'score_pre_test' => $result['score'],
                'module_status' => 'in_progress',
            ]
        );

        return redirect()->route('modules.show', $module)
            ->with('success', "✅ Pre-test selesai! Skor kamu: {$result['score']}/100. Selamat belajar!");
    }

    // ─── POST-TEST ─────────────────────────────────────────

    public function postTest(Module $module): View
    {
        $quiz = Quiz::where('type', 'post_test')
            ->whereHas('course', fn($q) => $q->where('module_id', $module->id))
            ->with('questions')
            ->firstOrFail();

        return view('quizzes.post-test', compact('module', 'quiz'));
    }

    public function submitPostTest(Module $module, Request $request): RedirectResponse
    {
        $quiz = Quiz::where('type', 'post_test')
            ->whereHas('course', fn($q) => $q->where('module_id', $module->id))
            ->with('questions')
            ->firstOrFail();

        $answers = $request->input('answers', []);
        $result  = $this->scoringService->calculate($quiz, $answers);

        // Save quiz answer
        $quizAnswer = UserQuizAnswer::create([
            'user_id'      => auth()->id(),
            'quiz_id'      => $quiz->id,
            'score'        => $result['score'],
            'answers'      => $answers,
            'passed'       => $result['passed'],
            'completed_at' => now(),
        ]);

        // Save score_post_test to user_progress + update module_status
        $moduleStatus = $result['passed'] ? 'completed' : 'in_progress';

        UserProgress::updateOrCreate(
            ['user_id' => auth()->id(), 'module_id' => $module->id],
            [
                'course_id'      => $quiz->course_id,
                'score_post_test' => $result['score'],
                'module_status'   => $moduleStatus,
                'is_completed'    => $result['passed'],
                'completed_at'    => $result['passed'] ? now() : null,
            ]
        );

        // Award gamification points on pass
        if ($result['passed']) {
            $user = auth()->user();
            $this->gamificationService->awardPoints($user, 'post_test_pass');

            // Update user level
            $user->refresh();
            $this->gamificationService->updateLevel($user);
        }

        $scoreLabel = "{$result['score']}/100";
        $message = $result['passed']
            ? "🎉 Selamat! Kamu lulus Post-test dengan skor {$scoreLabel}! Modul selesai."
            : "Skor Post-test kamu: {$scoreLabel}. Skor minimum 90. Pelajari lagi dan coba ulang.";

        return redirect()->route('modules.show', $module)
            ->with($result['passed'] ? 'success' : 'warning', $message);
    }

    // ─── Private Helpers ───────────────────────────────────

    private function issueCertificateIfEligible(Course $course): void
    {
        $passedCount = UserQuizAnswer::where('user_id', auth()->id())
            ->whereIn('quiz_id', $course->quizzes()->pluck('id'))
            ->where('passed', true)
            ->count();

        $totalQuizzes = $course->quizzes()->count();

        if ($passedCount >= $totalQuizzes && $totalQuizzes > 0) {
            if (!Certificate::where('user_id', auth()->id())->where('course_id', $course->id)->exists()) {
                Certificate::create([
                    'user_id'            => auth()->id(),
                    'course_id'          => $course->id,
                    'certificate_number' => 'CERT-' . strtoupper(uniqid()),
                    'issued_at'          => now(),
                    'expires_at'         => now()->addYear(),
                ]);
                $this->gamificationService->awardPoints(auth()->user(), 'certificate');
            }
        }
    }
}
