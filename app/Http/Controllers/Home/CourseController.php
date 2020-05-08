<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Home\HomeController;
use App\Models\Course;

class CourseController extends HomeController
{
    /**
     * Show Course on client site.
     *
     * @param  int  $code
     * @return void
     */
    public function show($code)
    {
        $p_course = Course::where('is_available', 1)->where('code', $code)->first();
        $p_lessons = $p_course->lessons->sortBy('number');

        if ($p_course) {
            return view('home.course', [
                'p_course' => $p_course,
                'p_lessons' => $p_lessons
            ]);
        } else {
            return redirect()->back();
        }
    }
}
