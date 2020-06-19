<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Chat;
use App\Models\Tutor;

class Thread extends Model
{
    protected $table = 'threads';

    protected $fillable = [
        'tutor_id', 'attendee_id', 'code', 'sheet', 'board', 'status'
    ];

    public function chats()
    {
        return $this->hasMany(Chat::class, 'thread_id');
    }

    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    public function attendee()
    {
        return $this->belongsTo(User::class, 'attendee_id');
    }
}
