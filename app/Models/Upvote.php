<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Reply;

class Upvote extends Model
{
    protected $table = 'upvotes';

    protected $fillable = [
        'reply_id', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reply()
    {
        return $this->belongsTo(Reply::class, 'reply_id');
    }
}
