<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\Models\Language;
use App\Models\Course;
use App\Models\TestType;
use App\Models\Test;
use App\Models\User;
use Session;

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
        $test_types = TestType::where('is_available', 1)->get();
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
        $online_number = 0;

        foreach (User::all() as $user) {
            if ($user->isOnline()) {
                $online_number++;
            }
        }

        return view('home.index', [
            'user_number' => User::count(),
            'online_number' => $online_number,
            'language_number' => Language::count(),
            'test_type_number' => TestType::count(),
            'course_number' => Course::count()
        ]);
    }

    /**
     * Change Web Display Language.
     *
     * @param string $locale
     * @return \Illuminate\Http\Response
     */
    public function changeLocale($locale)
    {
        \Session::put('web_locale', $locale);

        return redirect()->back();
    }
}
