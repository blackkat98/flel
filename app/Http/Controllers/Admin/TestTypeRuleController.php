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

        $tos = [];
        $scores = [];

        for ($i = 0; $i < 10; $i++) {
            if ($request->get('to-' . $i) != '' && $request->get('to-' . $i) != null) {
                $tos[] = $request->get('to-' . $i);

                if ($request->get('score-' . $i) != '' && $request->get('score-' . $i) != null) {
                    $scores[] = $request->get('score-' . $i);
                } else {
                    $scores[] = 0;
                }
            }
        }

        if (count($tos) > 0) {
            $rule->score_rules = array_combine($tos, $scores);
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
        //
    }
}
