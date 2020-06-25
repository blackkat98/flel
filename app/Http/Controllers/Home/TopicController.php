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
use Illuminate\Support\Facades\DB;
use App\Helper\AccentReduction;
use App\Helper\MediaDeletion;

class TopicController extends HomeController
{
    /**
     * Display a listing of the resource.
     *
     * @param string  $language_slug
     * @return \Illuminate\Http\Response
     */
    public function list($language_slug)
    {
        $p_language = Language::where('slug', $language_slug)->first();

        if (!$p_language) {
            return redirect()->route('home');
        }

        $p_tags = Tag::whereHas('topic', function ($q) use ($p_language) {
            $q->where('language_id', '=', $p_language->id);
        })->distinct('key')->get();

        $p_topics = DB::table('topics')->where('language_id', $p_language->id)->paginate(10);

        return view('home.topics', [
            'p_language' => $p_language,
            'p_topics' => $p_topics,
            'p_tags' => $p_tags->sortBy('key')
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param string  $language_slug
     * @param string  $tag_key
     * @return \Illuminate\Http\Response
     */
    public function listByTag($language_slug, $tag_key)
    {
        $p_language = Language::where('slug', $language_slug)->first();

        if (!$p_language) {
            return redirect()->route('home');
        }

        $p_tags = Tag::whereHas('topic', function ($q) use ($p_language) {
            $q->where('language_id', '=', $p_language->id);
        })->distinct('key')->get();

        $p_topics = DB::table('topics')
                ->join('tags', function ($q) use ($tag_key) {
                    $q->on('tags.topic_id', '=', 'topics.id');
                })
                ->where('topics.language_id', $p_language->id)
                ->where('tags.key', '=', $tag_key)
                ->select('topics.*')
                ->paginate(10);

        return view('home.topics_by_tag', [
            'p_language' => $p_language,
            'p_topics' => $p_topics,
            'p_tags' => $p_tags->sortBy('key'),
            'p_tag_key' => $tag_key
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

        foreach ($p_replies as $p_reply) {
            $p_reply->parent = $p_reply->parentReply();
        }

        return view('home.topic', [
            'p_language' => $p_language,
            'p_topic' => $p_topic,
            'p_replies' => $p_replies
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $language_slug
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($language_slug, $id)
    {
        $p_language = Language::where('slug', $language_slug)->first();

        if (!$p_language) {
            return redirect()->route('home');
        }

        $p_topic = Topic::find($id);

        if (Auth::user()->id != $p_topic->user_id) {
            return redirect()->route('home-topic-list', [
                'language_slug' => $p_language->slug
            ]);
        }

        if (!$p_topic) {
            return redirect()->route('home-topic-list', [
                'language_slug' => $p_language->slug
            ]);
        }

        $p_tags = $p_topic->tags;

        return view('home.edit_topic', [
            'p_language' => $p_language,
            'p_topic' => $p_topic,
            'p_tags' => $p_tags
        ]);
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
        $topic = Topic::findOrFail($id);

        if (Auth::user()->id != $topic->user_id) {
            return;
        }

        $topic->title = $request->get('title');
        $topic->content = $request->get('content');

        $language = $topic->language;
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

            if ($topic->attachment != null) {
                MediaDeletion::delete($topic->attachment);
            }

            $topic->attachment = config('customize.storage_dir') . $path;
        }

        if ($topic->save()) {
            $old_tags = $topic->tags;

            foreach ($old_tags as $old_tag) {
                $old_tag->delete();
            }

            static::createTag($tags, $topic->id);

            return redirect()->route('home-topic-show', [
                'language_slug' => $language->slug,
                'id' => $topic->id
            ])->with('success', $topic->title . ' ' . __('has been updated'));
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
        $topic = Topic::findOrFail($id);

        if ($topic->user_id != Auth::user()->id) {
            return;
        }

        if ($topic->delete()) {
            $replies = $topic->replies;
            $tags = $topic->tags;

            foreach ($replies as $reply) {
                $reply->delete();
            }

            foreach ($tags as $tag) {
                $tag->delete();
            }

            return redirect()->route('home-topic-list', [
                'language_slug' => $topic->language->slug
            ])->with('success', $topic->title . ' ' . __('has been deleted'));
        } else {
            return redirect()->back()->with('error', __('Action Failed'));
        }
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

    /**
     * Change availability.
     *
     * @param  int  $id
     * @return void
     */
    public function ajaxAvailable($id)
    {
        $topic = Topic::findOrFail($id);

        if (Auth::user()->id != $topic->user_id) {
            return;
        }

        if ($topic->is_open == 1) {
            $topic->is_open = 0;
        } else {
            $topic->is_open = 1;
        }

        if ($topic->save()) {
            return [
                'status' => 'successful',
                'msg' => $topic->title . ' ' . __('has been updated'),
                'topic' => $topic
            ];
        } else {
            return [
                'status' => 'failed',
                'msg' => $topic->title . ' ' . __('has been updated')
            ];
        }
    }
}
