<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TestTypeRuleRequest;
use App\Http\Controllers\Admin\AdminController;
use App\Models\TestTypeRule;
use App\Models\TestType;

class TestTypeRuleController extends AdminController
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
     * @param  App\Http\Requests\TestTypeRuleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TestTypeRuleRequest $request)
    {
        $rule = new TestTypeRule();
        $rule->test_type_id = $request->get('test_type_id');
        $rule->score_rule_type = $request->get('score_rule_type');
        $rule->extra = $request->get('extra');

        $test_type = TestType::findOrFail($request->get('test_type_id'));
        $score_rules = [];

        for ($j = 0; $j < count($test_type->fixed_parts); $j++) {
            $tos = [];
            $scores = [];

            for ($k = 0; $k < 10; $k++) {
                if ($request->get('to-' . $k . '-' . $j) != '' && $request->get('to-' . $k . '-' . $j) != null) {
                    $tos[] = $request->get('to-' . $k . '-' . $j);

                    if ($request->get('score-' . $k . '-' . $j) != '' && $request->get('score-' . $k . '-' . $j) != null) {
                        $scores[] = $request->get('score-' . $k . '-' . $j);
                    } else {
                        $scores[] = 0;
                    }
                }
            }

            $score_rules[$test_type->fixed_parts[$j]] = array_combine($tos, $scores);
        }

        if (count($score_rules) > 0) {
            $rule->score_rules = $score_rules;
        }

        if ($rule->save()) {
            return redirect()->back()->with('success', $rule->testType->name . ' ' . __('has been created'));
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
     * @param  App\Http\Requests\TestTypeRuleRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TestTypeRuleRequest $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rule = TestTypeRule::findOrFail($id);

        if ($rule->delete()) {
            return redirect()->back()->with('success', $rule->testType->name . ' ' . __('has been delete'));
        } else {
            return redirect()->back()->with('error', __('Action Failed'));
        }
    }
}
