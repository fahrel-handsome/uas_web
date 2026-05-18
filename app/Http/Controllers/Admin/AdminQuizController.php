<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Http\Request;

class AdminQuizController extends Controller
{
    public function index(Module $module)
    {
        // View quizzes attached to any course within the module.
        // Or if the quiz is tied to the module (if course_id is basically representing the module)
        // Let's get courses in this module and their quizzes.
        $module->load('courses.quizzes');
        return view('admin.quizzes.index', compact('module'));
    }

    public function manageQuestions(Quiz $quiz)
    {
        $quiz->load('questions');
        return view('admin.quizzes.questions', compact('quiz'));
    }

    public function storeQuestion(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'question_text' => 'required|string',
            'option_0' => 'required|string',
            'option_1' => 'required|string',
            'option_2' => 'required|string',
            'option_3' => 'required|string',
            'correct_option' => 'required|integer|in:0,1,2,3',
        ]);

        $quiz->questions()->create([
            'question' => $validated['question_text'],
            'options' => [
                $validated['option_0'],
                $validated['option_1'],
                $validated['option_2'],
                $validated['option_3']
            ],
            'correct_answer' => (int) $validated['correct_option'],
            'order' => $quiz->questions()->count() + 1,
        ]);

        return redirect()->back()->with('success', 'Soal berhasil ditambahkan!');
    }

    public function updateQuestion(Request $request, Quiz $quiz, Question $question)
    {
        $validated = $request->validate([
            'question_text' => 'required|string',
            'option_0' => 'required|string',
            'option_1' => 'required|string',
            'option_2' => 'required|string',
            'option_3' => 'required|string',
            'correct_option' => 'required|integer|in:0,1,2,3',
        ]);

        $question->update([
            'question' => $validated['question_text'],
            'options' => [
                $validated['option_0'],
                $validated['option_1'],
                $validated['option_2'],
                $validated['option_3']
            ],
            'correct_answer' => (int) $validated['correct_option'],
        ]);

        return redirect()->back()->with('success', 'Soal berhasil diperbarui!');
    }

    public function destroyQuestion(Quiz $quiz, Question $question)
    {
        $question->delete();
        return redirect()->back()->with('success', 'Soal berhasil dihapus!');
    }
}
