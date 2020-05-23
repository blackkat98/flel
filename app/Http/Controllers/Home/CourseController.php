<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Home\HomeController;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\UserCourse;
use Illuminate\Support\Facades\Auth;

class CourseController extends HomeController
{
    /**
     * Show Course on client site.
     *
     * @param  string  $code
     * @return void
     */
    public function show($code)
    {
        $p_course = Course::where('is_available', 1)->where('code', $code)->first();

        if ($p_course) {
            $p_lessons = $p_course->lessons->sortBy('number');
            $related_courses = Course::where('is_available', 1)
                    ->where('id', '<>', $p_course->id)
                    ->where('language_id', $p_course->language_id)
                    ->inRandomOrder()->limit(5)->get();
            $p_user_course = UserCourse::where('user_id', Auth::user()->id)
                    ->where('course_id', $p_course)->first();
            $progress_number = $p_user_course != null ? $p_user_course->progress_lesson_number : 1;

            return view('home.course', [
                'p_course' => $p_course,
                'p_lessons' => $p_lessons,
                'related_courses' => $related_courses,
                'progress_number' => $progress_number
            ]);
        } else {
            return redirect()->route('home');
        }
    }
}
