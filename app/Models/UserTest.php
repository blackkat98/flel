<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Test;

class UserTest extends Model
{
    protected $table = 'user_tests';

    protected $fillable = [
        'user_id', 'test_id', 'attempt_number', 'score'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id');
    }
}
