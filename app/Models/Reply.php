<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Topic;
use App\Models\User;
use App\Models\Upvote;

class Reply extends Model
{
    protected $table = 'replies';

    protected $fillable = [
        'topic_id', 'user_id', 'reply_id', 'content', 'attachment', 'is_approved'
    ];

    public function topic()
    {
        return $this->belongsTo(Topic::class, 'topic_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Return the Parent Reply.
     *
     * @return App\Models\Reply|null
     */
    public function parentReply()
    {
        if ($this->reply_id == 0) {
            return null;
        } else {
            $reply = Reply::findOrFail($this->reply_id);

            return $reply;
        }
    }

    /**
     * Return the Child Replies.
     *
     * @return App\Models\Reply|null
     */
    public function childReplies()
    {
        $replies = static::where('reply_id', $this->id)->get();

        return $replies;
    }
}
