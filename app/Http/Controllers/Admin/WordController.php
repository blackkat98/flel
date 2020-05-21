<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\WordRequest;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Word;
use App\Models\WordCategory;
use Illuminate\Support\Facades\Storage;
use App\Enums\WordType;

class WordController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $words = Word::all();
        $word_categories = WordCategory::all();
        $word_types = array_flip(WordType::toArray());

        return view('admin.words.list', [
            'words' => $words,
            'word_categories' => $word_categories,
            'word_types' => $word_types
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\WordRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WordRequest $request)
    {
        $word = new Word();
        $word->word_category_id = $request->get('word_category_id');
        $word->word = $request->get('word');
        $word->ipa = $request->get('ipa');
        $word->definition = $request->get('definition');
        $word->example = $request->get('example');

        $total_type_number = count(WordType::toArray());
        $word_type = [];

        for ($i = 0; $i < $total_type_number; $i++) {
            if ($request->get('word-type-' . $i)) {
                $word_type[] = $i;
            }
        }

        if (count($word_type) > 0) {
            $word->word_type = $word_type;
        } else {
            return redirect()->back()->with('warning', __('Type') . ' ' . __('is required'));
        }

        if ($request->hasFile('pronunciation')) {
            $path = Storage::disk('public')->put(config('customize.sound_dir'), $request->file('pronunciation'));
            $word->pronunciation = config('customize.storage_dir') . $path;
        }

        if ($word->save()) {
            return redirect()->back()->with('success', $word->word . ' ' . __('has been created'));
        } else {
            return redirect()->back()->with('error', __('Action Failed'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\WordRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(WordRequest $request, $id)
    {
        $word = Word::findOrFail($id);
        $word->word_category_id = $request->get('word_category_id');
        $word->word = $request->get('word');
        $word->ipa = $request->get('ipa');
        $word->definition = $request->get('definition');
        $word->example = $request->get('example');

        $total_type_number = count(WordType::toArray());
        $word_type = [];

        for ($i = 0; $i < $total_type_number; $i++) {
            if ($request->get('word-type-' . $i)) {
                $word_type[] = $i;
            }
        }

        if (count($word_type) > 0) {
            $word->word_type = $word_type;
        } else {
            return redirect()->back()->with('warning', __('Type') . ' ' . __('is required'));
        }

        if ($request->hasFile('pronunciation')) {
            $path = Storage::disk('public')->put(config('customize.sound_dir'), $request->file('pronunciation'));
            $word->pronunciation = config('customize.storage_dir') . $path;
        }

        if ($word->save()) {
            return redirect()->back()->with('success', $word->word . ' ' . __('has been updated'));
        } else {
            return redirect()->back()->with('error', __('Action Failed'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $word = Word::findOrFail($id);

        if ($word->delete()) {
            return redirect()->back()->with('success', $word->word . ' ' . __('has been deleted'));
        } else {
            return redirect()->back()->with('error', __('Action Failed'));
        }
    }
}
