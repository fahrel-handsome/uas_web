<?php

namespace App\Services;

use App\Models\Quiz;

class QuizScoringService
{
    /**
     * Calculate score from quiz answers.
     *
     * @param Quiz $quiz (with questions loaded)
     * @param array $answers [question_id => answer_index]
     * @return array{score: int, passed: bool, correct: int, total: int}
     */
    public function calculate(Quiz $quiz, array $answers): array
    {
        $total   = $quiz->questions->count();
        $correct = 0;

        if ($total === 0) {
            return ['score' => 0, 'passed' => false, 'correct' => 0, 'total' => 0];
        }

        foreach ($quiz->questions as $question) {
            $given = isset($answers[$question->id]) ? (int) $answers[$question->id] : -1;
            if ($given === $question->correct_answer) {
                $correct++;
            }
        }

        $score  = (int) round(($correct / $total) * 100);
        $passed = $score >= ($quiz->passing_score ?? 70);

        return compact('score', 'passed', 'correct', 'total');
    }
}
