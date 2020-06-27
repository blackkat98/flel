<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Home\HomeController;
use App\Models\UserTest;
use App\Models\UserCourse;
use App\Models\Lesson;
use App\Models\Test;
use Illuminate\Support\Facades\Auth;

class StatisticsController extends HomeController
{
    public function index()
    {
        $user_courses = UserCourse::where('user_id', Auth::user()->id)->get();
        $p_tests = Test::whereHas('userTests', function ($q) {
            $q->where('user_id', '=', Auth::user()->id);
        })->get();

        foreach ($user_courses as $u_course) {
            $u_course->saved_lesson = Lesson::where('course_id', $u_course->course_id)
                    ->where('number', $u_course->progress_lesson_number)->first();
        }

        return view('home.statistics', [
            'user_courses' => $user_courses->sortByDesc('create_at'),
            'p_tests' => $p_tests
        ]);
    }
}
