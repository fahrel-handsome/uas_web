<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\UserProgress;
use App\Models\CompletedLesson;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index(): View
    {
        $courses = Course::where('is_published', true)
            ->with('module')
            ->paginate(12);

        return view('courses.index', ['courses' => $courses]);
    }

    public function show(Course $course): View
    {
        $course->load('module', 'lessons', 'quizzes');
        
        $progress = null;
        if (auth()->check()) {
            $progress = UserProgress::where('user_id', auth()->id())
                ->where('course_id', $course->id)
                ->first();
        }

        return view('courses.show', [
            'course' => $course,
            'progress' => $progress
        ]);
    }

    public function lesson(Course $course, Lesson $lesson): View
    {
        if ($lesson->course_id !== $course->id) {
            abort(404);
        }

        $this->ensureUserProgress($course);
        
        $nextLesson = Lesson::where('course_id', $course->id)
            ->where('order', '>', $lesson->order)
            ->first();

        return view('courses.lesson', [
            'course' => $course,
            'lesson' => $lesson,
            'nextLesson' => $nextLesson
        ]);
    }

    public function completeLesson(Course $course, Lesson $lesson): RedirectResponse
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if ($lesson->course_id !== $course->id) {
            abort(404);
        }

        $existingCompletion = CompletedLesson::where('user_id', auth()->id())
            ->where('lesson_id', $lesson->id)
            ->exists();

        if (!$existingCompletion) {
            CompletedLesson::create([
                'user_id' => auth()->id(),
                'lesson_id' => $lesson->id,
                'completed_at' => now()
            ]);

            $progress = $this->ensureUserProgress($course);
            $progress->completed_lessons += 1;
            $progress->updateProgress();

            auth()->user()->ensureUserPointsExist();
            auth()->user()->userPoints->addPoints(10);
        }

        $nextLesson = Lesson::where('course_id', $course->id)
            ->where('order', '>', $lesson->order)
            ->first();

        if ($nextLesson) {
            return redirect()->route('courses.lesson', [$course, $nextLesson]);
        }

        return redirect()->route('courses.show', $course);
    }

    private function ensureUserProgress(Course $course)
    {
        $progress = UserProgress::where('user_id', auth()->id())
            ->where('course_id', $course->id)
            ->first();

        if (!$progress) {
            $totalLessons = $course->lessons()->count();
            $progress = UserProgress::create([
                'user_id' => auth()->id(),
                'course_id' => $course->id,
                'completed_lessons' => 0,
                'total_lessons' => $totalLessons,
                'progress_percentage' => 0
            ]);
        }

        return $progress;
    }
}
