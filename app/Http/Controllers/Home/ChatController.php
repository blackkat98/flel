<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Home\HomeController;
use App\Models\Chat;
use App\Models\Thread;
use App\Models\User;
use App\Models\TutorContact;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Enums\NotiType;

class ChatController extends HomeController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxStore(Request $request)
    {
        $thread = Thread::findOrFail($request->thread_id);

        if ($thread->tutor_id != Auth::user()->id && $thread->attendee_id != Auth::user()->id) {
            return;
        }

        $receiver_id = $thread->attendee_id == Auth::user()->id ? $thread->tutor_id : $thread->attendee_id;

        $chat = new Chat();
        $chat->thread_id = $request->thread_id;
        $chat->sender_user_id = Auth::user()->id;
        $chat->receiver_user_id = $receiver_id;
        $chat->message = $request->message;
        $chat->attachment = '';
        $chat->is_read = 0;

        if ($chat->save()) {
            return [
                'status' => 'successful',
                'msg' => __('A new Message') . ' ' . __('has been created'),
                'chat' => $chat
            ];
        } else {
            return [
                'status' => 'failed',
                'msg' => __('Action failed')
            ];
        }
    }
}
