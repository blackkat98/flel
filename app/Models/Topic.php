<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Reply;
use App\Models\Tag;

class Topic extends Model
{
    protected $table = 'topics';

    protected $fillable = [
        'language_id', 'user_id', 'title', 'content', 'attachment', 'is_open'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function replies()
    {
        return $this->hasMany(Reply::class, 'topic_id');
    }

    public function tags()
    {
        return $this->hasMany(Tag::class, 'topic_id');
    }
}
