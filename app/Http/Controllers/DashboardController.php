<?php

namespace App\Http\Controllers;

use App\Models\UserProgress;
use App\Models\Certificate;
use App\Models\UserQuizAnswer;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        auth()->user()->ensureUserPointsExist();

        $enrolledCourses = UserProgress::where('user_id', auth()->id())
            ->with('course.module')
            ->get();

        $completedCourses = UserProgress::where('user_id', auth()->id())
            ->where('is_completed', true)
            ->count();

        $certificates = Certificate::where('user_id', auth()->id())->count();
        $userPoints = auth()->user()->userPoints;

        $quizResults = UserQuizAnswer::where('user_id', auth()->id())
            ->with('quiz.course')
            ->orderBy('completed_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', [
            'enrolledCourses' => $enrolledCourses,
            'completedCourses' => $completedCourses,
            'certificates' => $certificates,
            'userPoints' => $userPoints,
            'quizResults' => $quizResults
        ]);
    }
}
