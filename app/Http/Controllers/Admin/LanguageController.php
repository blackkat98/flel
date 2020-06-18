<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\LanguageRequest;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Language;

class LanguageController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $languages = Language::all();
        
        return view('admin.languages.list', [
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
     * @param  App\Http\Requests\LanguageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LanguageRequest $request)
    {
        $language = new Language();
        $language->name = $request->get('name');
        $language->slug = $request->get('slug');
        
        if ($language->save()) {
            return redirect()->back()->with('success', $language->name . ' ' . __('has been created'));
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
     * @param  App\Http\Requests\LanguageRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LanguageRequest $request, $id)
    {
        $language = Language::findOrFail($id);
        $language->name = $request->get('name');
        $language->slug = $request->get('slug');
        
        if ($language->save()) {
            return redirect()->back()->with('success', $language->name . ' ' . __('has been updated'));
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
        $language = Language::findOrFail($id);

        if (count($language->courses) > 0 || count($language->testTypes) > 0 || count($language->topics) > 0 || count($language->tutorContacts) > 0) {
            return redirect()->back()->with('error', __('Action Failed'));
        }
        
        if ($language->delete()) {
            return redirect()->back()->with('success', $language->name . ' ' . __('has been deleted'));
        } else {
            return redirect()->back()->with('error', __('Action Failed'));
        }
    }
}
