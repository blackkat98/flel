<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TestPartRequest;
use App\Http\Controllers\Admin\AdminController;
use App\Models\TestPart;
use Illuminate\Support\Facades\Storage;

class TestPartController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  App\Http\Requests\TestPartRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TestPartRequest $request)
    {
        $test_part = new TestPart();
        $test_part->test_id = $request->get('test_id');
        $test_part->name = $request->get('name');
        $test_part->description = $request->get('description');
        
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
        
        $test_part->images = count($images) > 0 ? $images : null;
        
        if ($request->hasFile('sound')) {
            $path4 = Storage::disk('public')->put(config('customize.sound_dir'), $request->file('sound'));
            $test_part->sound = config('customize.storage_dir') . $path4;
        }
        
        if ($request->hasFile('video')) {
            $path5 = Storage::disk('public')->put(config('customize.video_dir'), $request->file('video'));
            $test_part->video = config('customize.storage_dir') . $path5;
        }
        
        if ($test_part->save()) {
            return redirect()->back()->with('success', $test_part->name . ' ' . __('has been created'));
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
     * @param  App\Http\Requests\TestPartRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TestPartRequest $request, $id)
    {
        $test_part = TestPart::findOrFail($id);
        // $test_part->test_id = $request->get('test_id');
        $test_part->name = $request->get('name');
        $test_part->description = $request->get('description');
        
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
        
        if (count($images) > 0) {
            $test_part->images = $images;
        }
        
        if ($request->hasFile('sound')) {
            $path4 = Storage::disk('public')->put(config('customize.sound_dir'), $request->file('sound'));
            $test_part->sound = config('customize.storage_dir') . $path4;
        }
        
        if ($request->hasFile('video')) {
            $path5 = Storage::disk('public')->put(config('customize.video_dir'), $request->file('video'));
            $test_part->video = config('customize.storage_dir') . $path5;
        }
        
        if ($test_part->save()) {
            return redirect()->back()->with('success', $test_part->name . ' ' . __('has been updated'));
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
