<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Home\HomeController;
use Illuminate\Support\Facades\Auth;
use App\Models\UserTest;
use App\Models\User;
use App\Models\Test;
use App\Models\TestPart;
use App\Models\TestQuiz;
use App\Models\TestType;
use App\Models\TestTypeRule;
use App\Enums\TestQuizType;
use App\Enums\ScoreRuleType;

class UserTestController extends HomeController
{
    public function list()
    {

    }

    /**
     * Save a new User Test.
     *
     * @param  Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_test = new UserTest();
        $user_test->user_id = Auth::user()->id;
        $user_test->test_id = $request->get('test_id');
        $user_test->attempt_number = UserTest::where('user_id', Auth::user()->id)
                ->where('test_id', $request->get('test_id'))->count() + 1;

        $sheet = [];

        $test = Test::findOrFail($request->get('test_id'));

        foreach ($test->testParts as $part) {
            $sheet[$part->name] = [];

            foreach ($part->testQuizzes as $quiz) {
                $sheet[$part->name][$quiz->number] = [];
            }
        }

        foreach ($test->testParts as $part) {
            foreach ($part->testQuizzes as $quiz) {
                if ($quiz->quiz_type == TestQuizType::multiple_choice) {
                    foreach ($quiz->options as $key => $value) {
                        if ($request->get('answer-' . $part->id . '-' . $quiz->number . '-' . $key)) {
                            $sheet[$part->name][$quiz->number][] = $key;
                        }
                    }
                }

                if ($quiz->quiz_type == TestQuizType::writing) {
                    for ($i = 1; $i <= count($quiz->answer); $i++) {
                        $sheet[$part->name][$quiz->number][$i] = $request->get('answer-' . $part->id . '-' . $quiz->number . '-' . $i);
                    }
                }
            }
        }

        $user_test->sheet = $sheet;
        $score = static::calculateScore($sheet, $test, $test->testType->testTypeRule);
        $user_test->score = $score;

        if ($user_test->save()) {
            return redirect()->route('home-test-show-overall', [
                'type_slug' => $test->testType->slug,
                'code' => $test->code
            ]);
        } else {
            return redirect()->back();
        }
    }

    /**
     * Get User Test data from a Test of the Auth User.
     *
     * @param  int $test_id
     * @return \Illuminate\Http\Response
     */
    public function ajaxAttemptData($test_id)
    {
        $test = Test::findOrFail($test_id);

        $user_tests = UserTest::where('user_id', Auth::user()->id)
                ->where('test_id', $test->id)->get();

        $numbers = $user_tests->pluck('attempt_number')->toArray();
        $scores = $user_tests->pluck('score')->toArray();

        $numbers = array_merge([0], $numbers);
        $scores = array_merge([0], $scores);

        return [
            'numbers' => $numbers,
            'scores' => $scores
        ];
    }

    /**
     * Calculate Score.
     *
     * @param  array $sheet
     * @param  App\Models\Test $test
     * @param  App\Models\TestTypeRule $rule
     * @return \Illuminate\Http\Response
     */
    public static function calculateScore($sheet, Test $test, TestTypeRule $rule)
    {
        $score = 0;
        $correct_marks = [];

        foreach ($test->testType->fixed_parts as $part) {
            $correct_marks[$part] = '';
        }

        foreach ($test->testParts as $part) {
            foreach ($part->testQuizzes as $quiz) {
                if ($sheet[$part->name][$quiz->number] == $quiz->answer) {
                    $str = $correct_marks[$part->name];
                    $str = $str . '1';
                    $correct_marks[$part->name] = $str;
                } else {
                    $str = $correct_marks[$part->name];
                    $str = $str . '0';
                    $correct_marks[$part->name] = $str;
                }
            }
        }

        $score_rule = $rule->score_rules;

        switch ($rule->score_rule_type) {
            case ScoreRuleType::count:
                foreach ($test->testType->fixed_parts as $part) {
                    $number_of_correct = substr_count($correct_marks[$part], '1');
                    $keys = array_keys($score_rule[$part]);
                    $count_index = static::getLowerMax($keys, $number_of_correct);

                    $score += $score_rule[$part][$count_index];
                }

                break;
            
            case ScoreRuleType::each:
                foreach ($test->testType->fixed_parts as $part) {
                    $keys = array_keys($score_rule[$part]);
                    $values = array_values($score_rule[$part]);
                    $chunks_length = [$keys[0]];
                    $chunks_start = [0];
                    $chunks = [];
                    $marks = $correct_marks[$part];

                    for ($i = 1; $i < count($keys); $i++) {
                        $chunks_length[] = $keys[$i] - $keys[$i - 1];
                    }

                    for ($j = 0; $j < count($keys) - 1; $j++) {
                        $chunks_start[] = $keys[$j] - 1;
                    }

                    for ($k = 0; $k < count($keys); $k++) {
                        $chunks[] = substr($marks, $chunks_start[$k], $chunks_length[$k]);
                    }

                    for ($q = 0; $q < count($keys); $q++) {
                        $score += $values[$q] * substr_count($correct_marks[$part], '1');
                    }
                }

                break;
        }

        return $score;
    }

    /**
     * Find the maximum number that is lower than a given number from an array.
     *
     * @param  array $sheet
     * @param  int $needle
     * @return \Illuminate\Http\Response
     */
    public static function getLowerMax($array, $needle)
    {
        $array = sort($array);
        $max = 0;

        foreach ($array as $element) {
            if ($element <= $needle) {
                $max = $element;
            } else {
                break;
            }
        }

        return $max;
    }
}
