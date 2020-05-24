<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TestQuizRequest;
use App\Http\Controllers\Admin\AdminController;
use App\Models\TestQuiz;
use App\Enums\TestQuizType;
use Illuminate\Support\Facades\Storage;
use App\Helper\MediaDeletion;

class TestQuizController extends AdminController
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
     * @param  App\Http\Requests\TestQuizRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TestQuizRequest $request)
    {
        $test_quiz = new TestQuiz();
        $test_quiz->test_part_id = $request->get('test_part_id');
        $test_quiz->number = $request->get('number');
        $test_quiz->associated_quiz_id = $request->get('associated_quiz_id');
        $test_quiz->quiz_type = $request->get('quiz_type');
        $test_quiz->question = $request->get('question');
        $test_quiz->essay = $request->get('essay');

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
        
        $test_quiz->images = count($images) > 0 ? $images : null;
        
        if ($request->hasFile('sound')) {
            $path4 = Storage::disk('public')->put(config('customize.sound_dir'), $request->file('sound'));
            $test_quiz->sound = config('customize.storage_dir') . $path4;
        }
        
        if ($request->hasFile('video')) {
            $path5 = Storage::disk('public')->put(config('customize.video_dir'), $request->file('video'));
            $test_quiz->video = config('customize.storage_dir') . $path5;
        }

        $checks = [];
        $options = [];

        for ($i = 1; $i < 11; $i++) {
            if ($request->get('check-' . $i) != '' && $request->get('check-' . $i) != null) {
                $checks[] = $i;
            }
            
            if ($request->get('opt-' . $i) != '' && $request->get('opt-' . $i) != null) {
                $options[$i] = $request->get('opt-' . $i);
            }
        }

        if ($test_quiz->quiz_type == TestQuizType::multiple_choice) {
            $test_quiz->options = $options;
            $test_quiz->answer = $checks;
        }

        if ($test_quiz->quiz_type == TestQuizType::writing) {
            $test_quiz->answer = $options;
        }

        if ($test_quiz->save()) {
            return redirect()->back()->with('success', $test_quiz->number . ' ' . __('has been created'));
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
     * @param  App\Http\Requests\TestQuizRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TestQuizRequest $request, $id)
    {
        $test_quiz = TestQuiz::findOrFail($id);
        $test_quiz->number = $request->get('number');
        $test_quiz->associated_quiz_id = $request->get('associated_quiz_id');
        $test_quiz->quiz_type = $request->get('quiz_type');
        $test_quiz->question = $request->get('question');
        $test_quiz->essay = $request->get('essay');

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
            if ($test_quiz->images != null) {
                MediaDeletion::delete($test_quiz->images);
            }

            $test_quiz->images = $images;
        }
        
        if ($request->hasFile('sound')) {
            $path4 = Storage::disk('public')->put(config('customize.sound_dir'), $request->file('sound'));

            if ($test_quiz->sound != null) {
                MediaDeletion::delete($test_quiz->sound);
            }

            $test_quiz->sound = config('customize.storage_dir') . $path4;
        }
        
        if ($request->hasFile('video')) {
            $path5 = Storage::disk('public')->put(config('customize.video_dir'), $request->file('video'));

            if ($test_quiz->video != null) {
                MediaDeletion::delete($test_quiz->video);
            }

            $test_quiz->video = config('customize.storage_dir') . $path5;
        }

        $checks = [];
        $options = [];

        for ($i = 1; $i < 11; $i++) {
            if ($request->get('check-' . $i) != '' && $request->get('check-' . $i) != null) {
                $checks[] = $i;
            }
            
            if ($request->get('opt-' . $i) != '' && $request->get('opt-' . $i) != null) {
                $options[$i] = $request->get('opt-' . $i);
            }
        }

        if ($test_quiz->quiz_type == TestQuizType::multiple_choice && count($options) > 0  && count($checks) > 0) {
            $test_quiz->options = $options;
            $test_quiz->answer = $checks;
        }

        if ($test_quiz->quiz_type == TestQuizType::writing && count($options) > 0) {
            $test_quiz->answer = $options;
        }

        if ($test_quiz->save()) {
            return redirect()->back()->with('success', $test_quiz->number . ' ' . __('has been updated'));
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
        $test_quiz = TestQuiz::findOrFail($id);
        
        if ($test_quiz->delete()) {
            return redirect()->back()->with('success', $test_quiz->number . ' ' . __('has been deleted'));
        } else {
            return redirect()->back()->with('error', __('Action Failed'));
        }
    }
}
