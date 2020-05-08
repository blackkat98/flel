<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TestType;
use App\Models\TestPart;
use App\Models\User;
use App\Models\UserTest;

class Test extends Model
{
    protected $table = 'tests';

    protected $fillable = [
        'user_id', 'test_type_id', 'name', 'time', 'is_available'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function testType()
    {
        return $this->belongsTo(TestType::class, 'test_type_id');
    }

    public function testParts()
    {
        return $this->hasMany(TestPart::class, 'test_id');
    }

    public function userTests()
    {
        return $this->hasMany(UserTest::class, 'test_id');
    }
}
