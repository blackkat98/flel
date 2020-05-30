<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Notification extends Model
{
    protected $table = 'notifications';

    protected $fillable = [
        'user_id', 'display', 'link'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
