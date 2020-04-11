<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Test;
use App\Models\TestQuiz;

class TestPart extends Model
{
    protected $table = 'test_parts';
    
    protected $fillable = [
        'test_id', 'name', 'description', 'images', 'sound', 'video'
    ];

    protected $casts = [
        'images' => 'array'
    ];
    
    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id');
    }
    
    public function testQuizzes()
    {
        return $this->hasMany(TestQuiz::class, 'test_part_id');
    }
}
