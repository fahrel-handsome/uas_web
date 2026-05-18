<?php

namespace App\Services;

use App\Models\Quiz;
use App\Models\Question;

/**
 * Pure PHP 8.2 Quiz Scoring Service.
 *
 * Receives submitted answers array [question_id => answer_index],
 * matches against correct_answer in questions table,
 * returns percentage score 0-100.
 */
class QuizScoringService
{
    /**
     * Calculate score from a quiz and submitted answers.
     *
     * @param  Quiz  $quiz  (should have 'questions' relation loaded)
     * @param  array $answers  [question_id => answer_index]
     * @return array{score: int, passed: bool, correct: int, total: int, percentage: float}
     */
    public function calculate(Quiz $quiz, array $answers): array
    {
        // Ensure questions are loaded
        if (!$quiz->relationLoaded('questions')) {
            $quiz->load('questions');
        }

        $total   = $quiz->questions->count();
        $correct = 0;

        if ($total === 0) {
            return [
                'score'      => 0,
                'passed'     => false,
                'correct'    => 0,
                'total'      => 0,
                'percentage' => 0.0,
            ];
        }

        foreach ($quiz->questions as $question) {
            $submitted = isset($answers[$question->id])
                ? (int) $answers[$question->id]
                : -1;

            if ($submitted === (int) $question->correct_answer) {
                $correct++;
            }
        }

        $percentage = round(($correct / $total) * 100, 2);
        $score      = (int) $percentage;
        // User requested minimum 90%
        $passed     = $score >= 90;

        return compact('score', 'passed', 'correct', 'total', 'percentage');
    }

    /**
     * Calculate score directly from question IDs + answers without a Quiz model.
     * Used for unit testing or manual grading.
     *
     * @param  array $answers  [question_id => submitted_answer_index]
     * @return array{score: int, correct: int, total: int}
     */
    public function calculateFromIds(array $answers): array
    {
        if (empty($answers)) {
            return ['score' => 0, 'correct' => 0, 'total' => 0];
        }

        $questionIds = array_keys($answers);
        $questions   = Question::whereIn('id', $questionIds)->get();
        $total       = $questions->count();
        $correct     = 0;

        foreach ($questions as $question) {
            $submitted = isset($answers[$question->id])
                ? (int) $answers[$question->id]
                : -1;

            if ($submitted === (int) $question->correct_answer) {
                $correct++;
            }
        }

        $score = $total > 0 ? (int) round(($correct / $total) * 100) : 0;
        return compact('score', 'correct', 'total');
    }
}
