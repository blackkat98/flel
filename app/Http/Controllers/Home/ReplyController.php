<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Requests\ReplyRequest;
use App\Http\Controllers\Home\HomeController;
use App\Models\Topic;
use App\Models\Reply;
use App\Models\Upvote;
use App\Models\Language;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Events\ReplyEvent;

class ReplyController extends HomeController
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
     * @param  App\Http\Requests\ReplyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReplyRequest $request)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\ReplyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxStore(ReplyRequest $request)
    {
        $reply = new Reply();
        $reply->topic_id = $request->topic_id;
        $reply->reply_id = $request->reply_id;
        $reply->user_id = Auth::user()->id;
        $reply->content = $request->content;

        $topic = Topic::find($request->topic_id);

        if ($topic->is_open == 0) {
            return redirect()->route('home-topic-list', [
                'language_slug' => $topic->language->slug
            ]);
        }

        if (!$topic) {
            return redirect()->route('home');
        }

        if ($request->hasFile('attachment')) {
            $path = Storage::disk('public')->put(config('customize.attachment_dir'), $request->file('attachment'));
            $reply->attachment = config('customize.storage_dir') . $path;
        }

        if ($reply->save()) {
            return [
                'status' => 'successful',
                'msg' => __('Your Reply') . ' ' . __('has been created'),
                'reply' => $reply,
                'reply_owner' => $reply->user
            ];
        } else {
            return [
                'status' => 'failed',
                'msg' => __('Action Failed')
            ];
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
     * @param  App\Http\Requests\ReplyRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReplyRequest $request, $id)
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
