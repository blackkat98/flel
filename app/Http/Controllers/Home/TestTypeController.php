<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Home\HomeController;
use App\Models\TestType;
use App\Models\Language;
use App\Models\Test;

class TestTypeController extends HomeController
{
    /**
     * Show Test Type List in a Language.
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

        $p_test_types = TestType::where('language_id', $p_language->id)
                ->where('is_available', 1)->get();

        return view('home.test_types', [
            'p_language' => $p_language,
            'p_test_types' => $p_test_types
        ]);
    }

    /**
     * Show Test Type with its Tests on client site.
     *
     * @param  string  $slug
     * @return void
     */
    public function show($slug)
    {
        $p_test_type = TestType::where('slug', $slug)->first();

        if (!$p_test_type) {
            return redirect()->route('home');
        }

        $p_tests = $p_test_type->tests->where('is_available', 1)->sortByDesc('id');
        $related_types = TestType::where('language_id', $p_test_type->language_id)
                ->where('id', '<>', $p_test_type->id)
                ->where('is_available', 1)->get();

        if ($p_test_type->is_available == 0) {
            return redirect()->route('home');
        }

        return view('home.test_type', [
            'p_test_type' => $p_test_type,
            'p_tests' => $p_tests,
            'related_types' => $related_types
        ]);
    }
}
