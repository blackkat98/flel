<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TestTypeRequest;
use App\Http\Controllers\Admin\AdminController;
use App\Models\TestType;
use App\Models\Language;

class TestTypeController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $test_types = TestType::all(['id', 'language_id', 'name', 'description', 'created_at', 'updated_at']);
        $languages = Language::all(['id', 'name', 'slug']);
        
        return view('admin.test_types.list', [
            'test_types' => $test_types,
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
     * @param  App\Http\Requests\TestTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TestTypeRequest $request)
    {
        $test_type = new TestType();
        $test_type->language_id = $request->get('language_id');
        $test_type->name = $request->get('name');
        $test_type->description = $request->get('description');
        
        if ($test_type->save()) {
            return redirect()->back()->with('success', $test_type->name . ' ' . __('has been created'));
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
     * @param  App\Http\Requests\TestTypeRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TestTypeRequest $request, $id)
    {
        $test_type = TestType::findOrFail($id);
        $test_type->language_id = $request->get('language_id');
        $test_type->name = $request->get('name');
        $test_type->description = $request->get('description');
        
        if ($test_type->save()) {
            return redirect()->back()->with('success', $test_type->name . ' ' . __('has been updated'));
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
        $test_type = TestType::findOrFail($id);
        
        if ($test_type->delete()) {
            return redirect()->back()->with('success', $test_type->name . ' ' . __('has been deleted'));
        } else {
            return redirect()->back()->with('error', __('Action Failed'));
        }
    }
}
