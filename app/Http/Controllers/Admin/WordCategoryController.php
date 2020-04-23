<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\WordCategoryRequest;
use App\Http\Controllers\Admin\AdminController;
use App\Models\WordCategory;
use App\Models\Language;

class WordCategoryController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $word_categories = WordCategory::all(['id', 'language_id', 'name', 'created_at', 'updated_at']);
        $languages = Language::all(['id', 'name', 'slug']);

        return view('admin.word_categories.list', [
            'word_categories' => $word_categories,
            'languages' => $languages
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
     * @param  App\Http\Requests\WordCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WordCategoryRequest $request)
    {
        $word_category = new WordCategory();
        $word_category->name = $request->get('name');
        $word_category->language_id = $request->get('language_id');

        if ($word_category->save()) {
            return redirect()->back()->with('success', $word_category->name . ' ' . __('has been created'));
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
     * @param  App\Http\Requests\WordCategoryRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(WordCategoryRequest $request, $id)
    {
        $word_category = WordCategory::findOrFail($id);
        $word_category->name = $request->get('name');
        $word_category->language_id = $request->get('language_id');

        if ($word_category->save()) {
            return redirect()->back()->with('success', $word_category->name . ' ' . __('has been updated'));
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
        //
    }
}
