<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Home\HomeController;
use App\Models\WordCategory;
use App\Models\Word;
use App\Models\Language;
use App\Enums\WordType;

class WordCategoryController extends HomeController
{
    /**
     * Display a listing of the resource.
     *
     * @param  string  $language_slug
     * @return \Illuminate\Http\Response
     */
    public function list($language_slug)
    {
        $word_types = array_flip(WordType::toArray());
        $p_language = Language::where('slug', $language_slug)->first();

        if (!$p_language) {
            return redirect()->route('home');
        }

        $p_word_categories = WordCategory::where('language_id', $p_language->id)
                ->get()->sortBy('name');
        $p_words = [];

        foreach ($p_word_categories as $category) {
            $words_by_category = $category->words->sortBy('word');
            $p_words[$category->id] = $words_by_category;
        }

        return view('home.word_categories', [
            'p_language' => $p_language,
            'p_word_categories' => $p_word_categories,
            'p_words' => $p_words,
            'word_types' => $word_types
        ]);
    }
}
