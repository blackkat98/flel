<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Home\HomeController;
use App\Models\Course;
use App\Models\Lesson;

class LessonController extends HomeController
{
    /**
     * Show Course on client site.
     *
     * @param  int  $code
     * @param  int  $lesson_number
     * @return void
     */
    public function show($code, $lesson_number)
    {
        $p_course = Course::where('is_available', 1)->where('code', $code)->first();

        if ($p_course) {
            $p_lessons = $p_course->lessons->sortBy('number');
            $p_lesson = $p_lessons->where('number', $lesson_number)->first();
            $related_courses = Course::where('is_available', 1)
                    ->where('id', '<>', $p_course->id)
                    ->where('language_id', $p_course->language_id)
                    ->inRandomOrder()->limit(5)->get();

            if (!$p_lesson) {
                $max_number = $p_lessons->max('number');

                return redirect()->route('home-lesson-show', [
                    'code' => $code,
                    'lesson_number' => $max_number
                ]);
            }
            
            return view('home.lesson', [
                'p_course' => $p_course,
                'p_lessons' => $p_lessons,
                'p_lesson' => $p_lesson,
                'related_courses' => $related_courses
            ]);
        } else {
            return redirect()->route('home');
        }
    }
}
