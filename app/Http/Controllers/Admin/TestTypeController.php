<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TestTypeRequest;
use App\Http\Controllers\Admin\AdminController;
use App\Models\TestType;
use App\Models\Language;
use App\Enums\ScoreRuleType;

class TestTypeController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $test_types = TestType::all();
        $languages = Language::all()->sortBy('id');
        $score_rule_types = array_flip(ScoreRuleType::toArray());
        
        return view('admin.test_types.list', [
            'test_types' => $test_types,
            'languages' => $languages,
            'score_rule_types' => $score_rule_types
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
        $test_type->slug = $request->get('slug');
        $test_type->description = $request->get('description');
        $test_type->fixed_quiz_quantity = $request->get('fixed_quiz_quantity');
        $test_type->fixed_time = $request->get('fixed_time');

        $fixed_parts = [];

        for ($i = 0; $i < 5; $i++) {
            if ($request->get('part-' . $i) != '' && $request->get('part-' . $i) != null) {
                $fixed_parts[] = $request->get('part-' . $i);
            }
        }

        if (count($fixed_parts) < 1) {
            $fixed_parts[] = 'Default';
        }

        $test_type->fixed_parts = $fixed_parts;
        
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
        $test_type->slug = $request->get('slug');
        $test_type->description = $request->get('description');
        $test_type->fixed_quiz_quantity = $request->get('fixed_quiz_quantity');
        $test_type->fixed_time = $request->get('fixed_time');

        $fixed_parts = [];

        for ($i = 0; $i < 5; $i++) {
            if ($request->get('part-' . $i) != '' && $request->get('part-' . $i) != null) {
                $fixed_parts[] = $request->get('part-' . $i);
            }
        }

        if (count($fixed_parts) < 1) {
            $fixed_parts[] = 'Default';
        }

        if ($test_type->fixed_parts != $fixed_parts && $test_type->testTypeRule) {
            $test_type->testTypeRule->delete();
        }

        $test_type->fixed_parts = $fixed_parts;
        
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

    /**
     * Change availability.
     *
     * @param  int  $id
     * @return void
     */
    public function available($id)
    {
        $test_type = TestType::findOrFail($id);

        if ($test_type->is_available == 0) {
            $test_type->is_available = 1;
        } else {
            $test_type->is_available = 0;
        }

        if (!$test_type->testTypeRule) {
            $test_type->is_available = 0;
        }

        if ($test_type->save()) {
            return redirect()->back()->with('success', $test_type->name . ' ' . __('has been updated'));
        } else {
            return redirect()->back()->with('error', __('Action Failed'));
        }
    }
}
