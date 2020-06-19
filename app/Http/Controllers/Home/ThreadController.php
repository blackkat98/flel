<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Home\HomeController;
use App\Models\Thread;
use App\Models\User;
use App\Models\TutorContact;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Enums\NotiType;
use App\Enums\ThreadStatus;

class ThreadController extends HomeController
{
    /**
     * Display the specified resource.
     *
     * @param  string  $code
     * @return \Illuminate\Http\Response
     */
    public function show($code)
    {
        $thread = Thread::where('code', $code)->first();

        if (!$thread) {
            return redirect()->route('home');
        }

        $chats = $thread->chats;

        return view('home.thread', [
            'thread' => $thread,
            'chats' => $chats
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxStore(Request $request)
    {
        $thread = new Thread();
        $thread->tutor_id = $request->tutor_id;
        $thread->attendee_id = Auth::user()->id;
        $thread->code = md5(time() . $request->tutor_id . Auth::user()->id . rand(1, 100));
        $thread->sheet = '';
        $thread->board = '';
        $thread->status = ThreadStatus::started;

        $tutor = User::findOrFail($request->tutor_id);
        $attendee = Auth::user();

        if ($tutor->tutorContact == null) {
            return;
        }

        if ($tutor->id == $attendee->id) {
            return;
        }

        if ($thread->save()) {
            $noti_to_tutor = new Notification();
            $noti_to_tutor->notification_type = NotiType::new_thread;
            $noti_to_tutor->user_id = $tutor->id;
            $noti_to_tutor->display = $attendee->name . ' ' . __('wants to contact to you');
            $noti_to_tutor->link = route('home-thread-show', [
                'code' => $thread->code
            ]);
            $noti_to_tutor->is_read = 0;
            $noti_to_tutor->save();

            return [
                'status' => 'successful',
                'msg' => __('Thread') . ' ' . __('has been created'),
                'thread' => $thread,
                'noti_to_tutor' => $noti_to_tutor
            ];
        } else {
            return [
                'status' => 'failed',
                'msg' => __('Action Failed')
            ];
        }
    }
}
