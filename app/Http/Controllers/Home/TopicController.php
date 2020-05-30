<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Requests\TopicRequest;
use App\Http\Controllers\Home\HomeController;
use App\Models\Topic;
use App\Models\Reply;
use App\Models\Upvote;
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
        return view('home.topics', [

        ]);
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

        $language = Language::findOrFail($request->get('language_id'));
        $tags = [];

        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'tag-') === 0) {
                $tags[] = $value;
            }
        }

        if (count($tags) < 1) {
            return redirect()->back()->with('warning', __('Tags') . ' ' . __('is required'));
        }

        if ($request->hasFile('attachment')) {
            $path = Storage::disk('public')->put(config('customize.attachment_dir'), $request->file('attachment'));
            $topic->attachment = config('customize.storage_dir') . $path;
        }

        if ($topic->save()) {
            static::createTag($tags, $topic->id);

            return redirect()->route('home-topic-show', [
                'language_slug' => $language->slug,
                'id' => $topic->id
            ])->with('success', $topic->title . ' ' . __('has been created'));
        } else {
            return redirect()->back()->with('error', __('Action Failed'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $language_slug
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($language_slug, $id)
    {
        $p_language = Language::where('slug', $language_slug)->first();

        if (!$p_language) {
            return redirect()->route('home');
        }

        $p_topic = Topic::find($id);

        if (!$p_topic) {
            return redirect()->route('home-topic-list', [
                'language_slug' => $p_language->slug
            ]);
        }

        $p_replies = $p_topic->replies;

        return view('home.topic', [
            'p_language' => $p_language,
            'p_topic' => $p_topic,
            'p_replies' => $p_replies
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
    public static function createTag($tag_inputs, $topic_id)
    {
        foreach ($tag_inputs as $input) {
            $tag = new Tag();
            $tag->topic_id = $topic_id;
            $tag->key = strtolower(AccentReduction::normalize($input));

            $tag->save();
        }
    }
}
