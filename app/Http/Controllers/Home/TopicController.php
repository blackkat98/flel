<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Requests\TopicRequest;
use App\Http\Controllers\Home\HomeController;
use App\Models\Topic;
use App\Models\Language;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Helper\AccentReduction;

class TopicController extends HomeController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function create($slug)
    {
        $p_language = Language::where('slug', $slug)->first();

        if (!$p_language) {
            return redirect()->route('home');
        }

        return view('home.create_topic', [
            'p_language' => $p_language
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\TopicRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TopicRequest $request)
    {
        $topic = new Topic();
        $topic->language_id = $request->get('language_id');
        $topic->user_id = Auth::user()->id;
        $topic->title = $request->get('title');
        $topic->content = $request->get('content');

        $tags = [];

        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'tag-') === 0) {
                $tags[] = $value;
            }
        }

        if ($request->hasFile('attachment')) {
            $path = Storage::disk('public')->put(config('customize.attachment_dir'), $request->file('attachment'));
            $test_quiz->attachment = config('customize.storage_dir') . $path;
        }

        if ($topic->save()) {


            return redirect()->back()->with('success', $topic->title . ' ' . __('has been created'));
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
     * @param  App\Http\Requests\TopicRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TopicRequest $request, $id)
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

    /**
     * Create tags from certain inputs.
     *
     * @param  array  $tag_inputs
     * @param  int  $topic_id
     * @return \Illuminate\Http\Response
     */
    public function createTag($tag_inputs, $topic_id)
    {
        foreach ($tag_inputs as $input) {
            $tag = new Tag();
            $tag->topic_id = $topic_id;
            $tag->key = AccentReduction::normalize($input);

            $tag->save();
        }
    }
}
