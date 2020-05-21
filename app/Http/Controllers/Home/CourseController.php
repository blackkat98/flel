<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Home\HomeController;
use App\Models\Course;
use App\Models\Lesson;

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

            return view('home.course', [
                'p_course' => $p_course,
                'p_lessons' => $p_lessons,
                'related_courses' => $related_courses
            ]);
        } else {
            return redirect()->route('home');
        }
    }
}
