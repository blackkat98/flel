<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Home\HomeController;
use App\Models\Language;
use App\Models\TutorContact;

class TutorContactController extends HomeController
{
    /**
     * Display a listing of the resource.
     *
     * @param string  $language_slug
     * @return \Illuminate\Http\Response
     */
    public function list($language_slug)
    {
        $p_language = Language::where('slug', $language_slug)->first();

        if (!$p_language) {
            return redirect()->route('home');
        }

        $p_tutors = $p_language->tutorContacts;
        $p_languages = Language::all();

        return view('home.tutors', [
            'p_language' => $p_language,
            'p_languages' => $p_languages,
            'p_tutors' => $p_tutors
        ]);
    }
}
