<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Home\HomeController;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\UserCourse;
use App\Models\Language;
use Illuminate\Support\Facades\Auth;

class CourseController extends HomeController
{
    /**
     * Show Course on client site.
     *
     * @param  string  $language_slug
     * @return void
     */
    public function list($language_slug)
    {
        $p_language = Language::where('slug', $language_slug)->first();

        if (!$p_language) {
            return redirect()->route('home');
        }

        $p_courses = Course::where('language_id', $p_language->id)
                ->where('is_available', 1)->get();

        return view('home.courses', [
            'p_language' => $p_language,
            'p_courses' => $p_courses
        ]);
    }

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
