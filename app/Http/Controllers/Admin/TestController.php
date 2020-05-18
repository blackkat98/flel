<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TestRequest;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Test;
use App\Models\TestType;
use App\Models\TestPart;
use Illuminate\Support\Facades\Auth;
use App\Enums\TestQuizType;
use App\Enums\TestQuizOptionType;

class TestController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $tests = Test::all();
        $test_types = TestType::where('is_available', 1)->get()->sortBy('id');

        return view('admin.tests.list', [
            'tests' => $tests,
            'test_types' => $test_types
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
     * @param  App\Http\Requests\TestRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TestRequest $request)
    {
        $test = new Test();
        $test->user_id = Auth::user()->id;
        $test->name = $request->get('name');
        $test->test_type_id = $request->get('test_type_id');
        $test->time = $request->get('time');

        $test_type = TestType::findOrFail($request->get('test_type_id'));

        if ($test_type->fixed_time > 0) {
            $test->time = $test_type->fixed_time;
        }

        if ($test->save()) {
            foreach ($test_type->fixed_parts as $default_part) {
                $part = new TestPart();
                $part->test_id = $test->id;
                $part->name = $default_part;

                $part->save();
            }

            return redirect()->route('admin-tests-show', ['id' => $test->id])->with('success', $test->name . ' ' . __('has been created'));
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
        $test = Test::findOrFail($id);
        $test_types = TestType::all()->sortBy('id');
        $test_parts = $test->testParts->sortBy('id');
        $quizzes_in_parts = [];
        
        foreach ($test_parts as $part) {
            $quizzes_in_parts[] = $part->testQuizzes->sortBy('number');
        }
        
        $quiz_types = array_flip(TestQuizType::toArray());
        $quiz_option_types = array_flip(TestQuizOptionType::toArray());

        return view('admin.tests.show', [
            'test' => $test,
            'test_types' => $test_types,
            'test_parts' => $test_parts,
            'quizzes_in_parts' => $quizzes_in_parts,
            
            'quiz_types' => $quiz_types,
            'quiz_option_types' => $quiz_option_types
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
     * @param  App\Http\Requests\TestRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TestRequest $request, $id)
    {
        $test = Test::findOrFail($id);
        $test->name = $request->get('name');
        $test->time = $request->get('time');

        $test_type = $test->testType;

        if ($test_type->fixed_time > 0) {
            $test->time = $test_type->fixed_time;
        }

        if ($test->save()) {
            return redirect()->back()->with('success', $test->name . ' ' . __('has been updated'));
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
        $test = Test::findOrFail($id);

        foreach ($test->testParts as $part) {
            foreach ($part->testQuizzes as $quiz) {
                $quiz->delete();
            }

            $part->delete();
        }

        if ($test->delete()) {
            return redirect()->route('admin-tests-list')->with('success', $test->name . ' ' . __('has been deleted'));
        } else {
            return redirect()->back()->with('error', __('Action Failed'));
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
        $test = Test::findOrFail($id);

        if ($test->is_available == 0) {
            $test->is_available = 1;
        } else {
            $test->is_available = 0;
        }

        if ($test->save()) {
            return redirect()->back()->with('success', $test->name . ' ' . __('has been updated'));
        } else {
            return redirect()->back()->with('error', __('Action Failed'));
        }
    }
}
