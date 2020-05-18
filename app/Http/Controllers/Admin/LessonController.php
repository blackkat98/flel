<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\LessonRequest;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Lesson;
use Illuminate\Support\Facades\Storage;
use App\Helper\MediaDeletion;

class LessonController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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
     * @param  App\Http\Requests\LessonRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LessonRequest $request)
    {
        $lesson = new Lesson();
        $lesson->course_id = $request->get('course_id');
        $lesson->number = $request->get('number');
        $lesson->name = $request->get('name');
        $lesson->lecture = $request->get('lecture');

        $images = [];
        
        if ($request->hasFile('image-1')) {
            $path1 = Storage::disk('public')->put(config('customize.image_dir'), $request->file('image-1'));
            $images[] = config('customize.storage_dir') . $path1;
        }
        
        if ($request->hasFile('image-2')) {
            $path2 = Storage::disk('public')->put(config('customize.image_dir'), $request->file('image-2'));
            $images[] = config('customize.storage_dir') . $path2;
        }
        
        if ($request->hasFile('image-3')) {
            $path3 = Storage::disk('public')->put(config('customize.image_dir'), $request->file('image-3'));
            $images[] = config('customize.storage_dir') . $path3;
        }

        if ($request->hasFile('image-4')) {
            $path4 = Storage::disk('public')->put(config('customize.image_dir'), $request->file('image-4'));
            $images[] = config('customize.storage_dir') . $path4;
        }
        
        $lesson->images = count($images) > 0 ? $images : null;
        
        if ($request->hasFile('sound')) {
            $path4 = Storage::disk('public')->put(config('customize.sound_dir'), $request->file('sound'));
            $lesson->sound = config('customize.storage_dir') . $path4;
        }

        if ($request->hasFile('video')) {
            $path5 = Storage::disk('public')->put(config('customize.video_dir'), $request->file('video'));
            $lesson->video = config('customize.storage_dir') . $path5;
        }

        if ($lesson->save()) {
            return redirect()->back()->with('success', $lesson->name . ' ' . __('has been created'));
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
     * @param  App\Http\Requests\LessonRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LessonRequest $request, $id)
    {
        $lesson = Lesson::findOrFail($id);
        // $lesson->course_id = $request->get('course_id');
        $lesson->number = $request->get('number');
        $lesson->name = $request->get('name');
        $lesson->lecture = $request->get('lecture');

        $images = [];
        
        if ($request->hasFile('image-1')) {
            $path1 = Storage::disk('public')->put(config('customize.image_dir'), $request->file('image-1'));
            $images[] = config('customize.storage_dir') . $path1;
        }
        
        if ($request->hasFile('image-2')) {
            $path2 = Storage::disk('public')->put(config('customize.image_dir'), $request->file('image-2'));
            $images[] = config('customize.storage_dir') . $path2;
        }
        
        if ($request->hasFile('image-3')) {
            $path3 = Storage::disk('public')->put(config('customize.image_dir'), $request->file('image-3'));
            $images[] = config('customize.storage_dir') . $path3;
        }

        if ($request->hasFile('image-4')) {
            $path4 = Storage::disk('public')->put(config('customize.image_dir'), $request->file('image-4'));
            $images[] = config('customize.storage_dir') . $path4;
        }
        
        if (count($images) > 0) {
            if ($lesson->images != null) {
                MediaDeletion::delete($lesson->images);
            }

            $lesson->images = $images;
        }
        
        if ($request->hasFile('sound')) {
            $path4 = Storage::disk('public')->put(config('customize.sound_dir'), $request->file('sound'));

            if ($lesson->sound != null) {
                MediaDeletion::delete($lesson->sound);
            }

            $lesson->sound = config('customize.storage_dir') . $path4;
        }

        if ($request->hasFile('video')) {
            $path5 = Storage::disk('public')->put(config('customize.video_dir'), $request->file('video'));

            if ($lesson->video != null) {
                MediaDeletion::delete($lesson->video);
            }

            $lesson->video = config('customize.storage_dir') . $path5;
        }

        if ($lesson->save()) {
            return redirect()->back()->with('success', $lesson->name . ' ' . __('has been created'));
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
        $lesson = Lesson::findOrFail($id);

        if ($lesson->delete()) {
            return redirect()->back()->with('success', $lesson->name . ' ' . __('has been deleted'));
        } else {
            return redirect()->back()->with('error', __('Action Failed'));
        }
    }
}
