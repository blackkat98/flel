<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CourseRequest;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Course;
use App\Models\Language;
use Illuminate\Support\Facades\Auth;

class CourseController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $courses = Course::all(['id', 'user_id', 'language_id', 'name', 'code', 'created_at', 'updated_at']);
        $languages = Language::all(['id', 'name', 'slug']);
        
        return view('admin.courses.list', [
            'courses' => $courses,
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
     * @param  App\Http\Requests\CourseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseRequest $request)
    {
        $course = new Course();
        $course->user_id = Auth::user()->id;
        $course->language_id = $request->get('language_id');
        $course->name = $request->get('name');
        
        $language = Language::findOrFail($request->get('language_id'));
        $slug = $language->slug;
        $max_id_course = Course::where('language_id', $language->id)->max('id');
        $max_id = $max_id_course != null ? $max_id_course->null : 0;
        
        $course->code = strtoupper($slug) . '-' . ($max_id + 1);
        
        if ($course->save()) {
            return redirect()->back()->with('success', $course->code . ' ' . __('has been created'));
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
     * @param  App\Http\Requests\CourseRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CourseRequest $request, $id)
    {
        $course = Course::findOrFail($id);
        $course->name = $request->get('name');
        
        if ($course->save()) {
            return redirect()->back()->with('success', $course->code . ' ' . __('has been updated'));
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
        $course = Course::findOrFail($id);
        
        if ($course->delete()) {
            return redirect()->back()->with('success', $course->code . ' ' . __('has been deleted'));
        } else {
            return redirect()->back()->with('error', __('Action Failed'));
        }
    }
}