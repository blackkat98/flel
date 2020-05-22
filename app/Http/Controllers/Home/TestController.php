<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Home\HomeController;
use App\Models\Test;
use App\Models\TestType;
use App\Models\UserTest;

class TestController extends HomeController
{
    /**
     * Display the specified resource.
     *
     * @param  string  $type_slug
     * @param  string  $code
     * @return void
     */
    public function showOverall($type_slug, $code)
    {
        $p_test_type = TestType::where('slug', $type_slug)->first();

        if (!$p_test_type) {
            return redirect()->route('home');
        }

        $p_test = Test::where('test_type_id', $p_test_type->id)
                ->where('code', $code)->first();

        if (!$p_test) {
            return redirect()->route('home-test-type-show', [
                'slug' => $p_test_type->slug
            ]);
        }

        return view('home.test', [
            'p_test_type' => $p_test_type,
            'p_test' => $p_test
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $type_slug
     * @param  string  $code
     * @return void
     */
    public function showDetail($type_slug, $code)
    {
        $p_test_type = TestType::where('slug', $type_slug)->first();

        if (!$p_test_type) {
            return redirect()->route('home');
        }

        $p_test = Test::where('test_type_id', $p_test_type->id)
                ->where('code', $code)->first();

        if (!$p_test) {
            return redirect()->route('home-test-type-show', [
                'slug' => $p_test_type->slug
            ]);
        }

        $p_test_parts = $test->testParts;
        $p_test_quizzes = [];

        foreach ($p_test_parts as $part) {
            $p_test_quizzes[$part->id] = $part->testQuizzes;
        }

        return view('home.test', [
            'p_test_type' => $p_test_type,
            'p_test' => $p_test,
            'p_test_parts' => $p_test_parts,
            'p_test_quizzes' => $p_test_quizzes
        ]);
    }
}
