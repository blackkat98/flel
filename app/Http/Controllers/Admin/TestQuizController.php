<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TestQuizRequest;
use App\Http\Controllers\Admin\AdminController;
use App\Models\TestQuiz;
use App\Enums\TestQuizType;

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
        $test_quiz->number = $request->get('number');
        $test_quiz->quiz_type = $request->get('quiz_type');

        $ticks = [];
        $options = [];

        for ($i = 0; $i < 10; $i++) {
            if ($request->get('tick-' . $i) != '' && $request->get('tick-' . $i) != null) {
                
            }
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
