<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Home\HomeController;
use App\Models\Test;
use App\Models\TestType;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Topic;
use Illuminate\Support\Facades\DB;
use App\Helper\AccentReduction;

class SearchController extends HomeController
{
    public function search(Request $request)
    {
        $text = $request->get('text');
        $normalized = AccentReduction::normalize($text);
        $lowered = strtolower($normalized);

        $test_types = TestType::where('name', 'LIKE', "%{$text}%")
                ->orWhere('name', 'LIKE', "%{$normalized}%")
                ->orWhere('name', 'LIKE', "%{$lowered}%")
                ->orWhere('slug', 'LIKE', "%{$text}%")
                ->orWhere('slug', 'LIKE', "%{$normalized}%")
                ->orWhere('slug', 'LIKE', "%{$lowered}%")->get();
        $tests = Test::where('name', 'LIKE', "%{$text}%")
                ->orWhere('name', 'LIKE', "%{$normalized}%")
                ->orWhere('name', 'LIKE', "%{$lowered}%")->get();
        $courses = Course::where('name', 'LIKE', "%{$text}%")
                ->orWhere('name', 'LIKE', "%{$normalized}%")
                ->orWhere('name', 'LIKE', "%{$lowered}%")
                ->orWhere('code', 'LIKE', "%{$text}%")
                ->orWhere('code', 'LIKE', "%{$normalized}%")
                ->orWhere('code', 'LIKE', "%{$lowered}%")->get();
        $lessons = Lesson::whereHas('course', function ($q) use ($text, $normalized, $lowered) {
            $q->where('name', 'LIKE', "%{$text}%")
                ->orWhere('name', 'LIKE', "%{$normalized}%")
                ->orWhere('name', 'LIKE', "%{$lowered}%")
                ->orWhere('code', 'LIKE', "%{$text}%")
                ->orWhere('code', 'LIKE', "%{$normalized}%")
                ->orWhere('code', 'LIKE', "%{$lowered}%");
        })->get();
        $topics = Topic::whereHas('tags', function ($q) use ($text, $normalized, $lowered) {
            $q->where('key', 'LIKE', "%{$lowered}%");
        })->orWhere('title', 'LIKE', "%{$text}%")
                ->orWhere('title', 'LIKE', "%{$normalized}%")
                ->orWhere('title', 'LIKE', "%{$lowered}%")->get();

        return view('home.search', [
            'p_test_types' => $test_types,
            'p_tests' => $tests,
            'p_courses' => $courses,
            'p_lessons' => $lessons,
            'p_topics' => $topics
        ]);
    }
}
