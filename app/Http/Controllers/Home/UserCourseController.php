<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Home\HomeController;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\UserCourse;
use Illuminate\Support\Facades\Auth;

class UserCourseController extends HomeController
{
    /**
     * Save Course Progress.
     *
     * @param  Illuminate\Http\Request  $request
     * @return void
     */
    public function store(Request $request)
    {
        $code = $request->get('code');
        $lesson_number = $request->get('lesson_number');

        $course = Course::where('code', $code)->first();

        if (!$course) {
            return redirect()->back();
        }

        $lesson = Lesson::where('course_id', $course->id)
                ->where('number', $lesson_number)->first();

        if (!$lesson) {
            return redirect()->back();
        }

        $user_course = UserCourse::where('user_id', Auth::user()->id)
                ->where('course_id', $course->id)
                ->where('progress_lesson_number', $lesson->number)->first();

        if (!$user_course) {
            $user_course = new UserCourse();
        }

        $user_course->user_id = Auth::user()->id;
        $user_course->course_id = $course->id;
        $user_course->progress_lesson_number = $lesson->number;

        if ($user_course->save()) {
            return redirect()->route('home-course-show', [
                'code' => $course->code
            ]);
        } else {
            return redirect()->back();
        }
    }
}
