<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Home\HomeController;
use App\Models\Notification;
use App\Models\Thread;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Redirect;

class NotificationController extends HomeController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function redirectByNoti(Request $request)
    {
        $id = $request->get('id');
        $noti = Notification::findOrFail($id);

        if ($noti->user->id != Auth::user()->id) {
            return;
        }

        $noti->is_read = 1;
        $noti->save();

        return Redirect::to($noti->link);
    }

    /**
     * Return Auth User's Unread Notifications.
     *
     * @return App\Models\Notification
     */
    public function ajaxLoadUnread()
    {
        $notifications = Notification::where('user_id', Auth::user()->id)
                ->where('is_read', 0)->get();

        return $notifications;
    }
}
