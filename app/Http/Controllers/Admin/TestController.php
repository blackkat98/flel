<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TestRequest;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Test;
use App\Models\TestType;
use App\Models\TestPart;
use Illuminate\Support\Facades\Auth;

class TestController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $tests = Test::all(['id', 'user_id', 'test_type_id', 'name', 'time', 'created_at', 'updated_at']);
        $test_types = TestType::all(['id', 'name'])->sortBy('id');

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

        if ($test->save()) {
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
        $test_types = TestType::all(['id', 'name'])->sortBy('id');
        $test_parts = $test->testParts->sortBy('id');

        return view('admin.tests.show', [
            'test' => $test,
            'test_types' => $test_types,
            'test_parts' => $test_parts
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
        $test->test_type_id = $request->get('test_type_id');
        $test->time = $request->get('time');

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
        //
    }
}
