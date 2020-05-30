<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Chat extends Model
{
    protected $table = 'chats';

    protected $fillable = [
        'sender_user_id', 'receiver_user_id', 'message', 'attachment', 'is_read'
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_user_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_user_id');
    }
}
