<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\Models\Language;
use App\Models\Course;
use App\Models\TestType;
use App\Models\Test;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
        $courses = Course::where('is_available', 1)->get();
        $languages = Language::all();
        $test_types = TestType::all();
        $tests = Test::where('is_available', 1)->inRandomOrder()->limit(10)->get();

        View::share('courses', $courses);
        View::share('languages', $languages);
        View::share('test_types', $test_types);
        View::share('tests', $tests);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home.index');
    }
}
