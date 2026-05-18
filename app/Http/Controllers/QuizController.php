<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Quiz;
use App\Models\Module;
use App\Models\Course;
use App\Models\UserQuizAnswer;
use App\Services\QuizScoringService;
use App\Services\GamificationService;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function __construct(
        private QuizScoringService $scoringService,
        private GamificationService $gamificationService
    ) {}

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

        $result = $this->scoringService->calculate($quiz, $answers);

        $quizAnswer = UserQuizAnswer::create([
            'user_id'      => auth()->id(),
            'quiz_id'      => $quiz->id,
            'score'        => $result['score'],
            'answers'      => $answers,
            'passed'       => $result['passed'],
            'completed_at' => now(),
        ]);

        if ($result['passed']) {
            $this->gamificationService->awardPoints(auth()->user(), 'quiz_pass', 50);
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

    // ====== PRE-TEST ======
    public function preTest(Module $module): View
    {
        $quiz = Quiz::where('type', 'pre_test')
            ->whereHas('course', fn($q) => $q->where('module_id', $module->id))
            ->with('questions')
            ->firstOrFail();

        return view('quizzes.pre-test', compact('module', 'quiz'));
    }

    public function submitPreTest(Module $module, Request $request): RedirectResponse
    {
        $quiz = Quiz::where('type', 'pre_test')
            ->whereHas('course', fn($q) => $q->where('module_id', $module->id))
            ->with('questions')
            ->firstOrFail();

        $answers = $request->input('answers', []);
        $result  = $this->scoringService->calculate($quiz, $answers);

        UserQuizAnswer::create([
            'user_id'      => auth()->id(),
            'quiz_id'      => $quiz->id,
            'score'        => $result['score'],
            'answers'      => $answers,
            'passed'       => true, // pre-test always allows proceed
            'completed_at' => now(),
        ]);

        return redirect()->route('modules.show', $module)
            ->with('success', "Pre-test selesai! Skor: {$result['score']}. Silakan mulai materi.");
    }

    // ====== POST-TEST ======
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

        UserQuizAnswer::create([
            'user_id'      => auth()->id(),
            'quiz_id'      => $quiz->id,
            'score'        => $result['score'],
            'answers'      => $answers,
            'passed'       => $result['passed'],
            'completed_at' => now(),
        ]);

        if ($result['passed']) {
            $this->gamificationService->awardPoints(auth()->user(), 'post_test_pass', 75);
        }

        return redirect()->route('modules.show', $module)
            ->with($result['passed'] ? 'success' : 'error',
                   "Post-test selesai! Skor: {$result['score']}. " .
                   ($result['passed'] ? '🎉 Lulus!' : 'Belum lulus, coba lagi.'));
    }

    private function issueCertificateIfEligible(Course $course): void
    {
        $passedQuizzes = UserQuizAnswer::where('user_id', auth()->id())
            ->whereIn('quiz_id', $course->quizzes()->pluck('id'))
            ->where('passed', true)->count();

        $totalQuizzes = $course->quizzes()->count();

        if ($passedQuizzes >= $totalQuizzes && $totalQuizzes > 0) {
            $exists = Certificate::where('user_id', auth()->id())
                ->where('course_id', $course->id)->exists();

            if (!$exists) {
                Certificate::create([
                    'user_id'            => auth()->id(),
                    'course_id'          => $course->id,
                    'certificate_number' => 'CERT-' . strtoupper(uniqid()),
                    'issued_at'          => now(),
                    'expires_at'         => now()->addYear(),
                ]);
                $this->gamificationService->awardPoints(auth()->user(), 'certificate', 100);
            }
        }
    }
}
