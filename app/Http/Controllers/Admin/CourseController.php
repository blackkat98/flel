<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CourseRequest;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Course;
use App\Models\Language;
use App\Models\Lesson;
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
        $courses = Course::all();
        $languages = Language::all();
        
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
        $course->description = $request->get('description');
        
        $language = Language::findOrFail($request->get('language_id'));
        $slug = $language->slug;
        $max_id_course = Course::where('language_id', $language->id)->max('id');
        $max_id = $max_id_course != null ? $max_id_course : 0;
        
        $course->code = $slug . '-' . ($max_id + 1);
        
        if ($course->save()) {
            return redirect()->route('admin-courses-show', ['id' => $course->id])->with('success', $course->code . ' ' . __('has been created'));
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
        $course = Course::findOrFail($id);
        $lessons = $course->lessons->sortBy('number');

        return view('admin.courses.show', [
            'course' => $course,
            'lessons' => $lessons
        ]);
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
        $course->description = $request->get('description');
        
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
        
        foreach ($course->lessons as $lesson) {
            $lesson->delete();
        }
        
        if ($course->delete()) {
            return redirect()->back()->with('success', $course->code . ' ' . __('has been deleted'));
        } else {
            return redirect()->route('admin-courses-list')->with('error', __('Action Failed'));
        }
    }

    /**
     * Change availability.
     *
     * @param  int  $id
     * @return void
     */
    public function available($id)
    {
        $course = Course::findOrFail($id);

        if ($course->is_available == 0) {
            $course->is_available = 1;
        } else {
            $course->is_available = 0;
        }

        if ($course->save()) {
            return redirect()->back()->with('success', $course->code . ' ' . __('has been updated'));
        } else {
            return redirect()->back()->with('error', __('Action Failed'));
        }
    }
}
