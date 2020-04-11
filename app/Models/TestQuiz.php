<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TestPart;

class TestQuiz extends Model
{
    protected $table = 'test_quizzes';
    
    protected $fillable = [
        'test_part_id', 'number', 'quiz_type', 'question', 'options', 'option_content_type', 'answer'
    ];
    
    protected $casts = [
        'options' => 'array',
        'answer' => 'array'
    ];


    public function testPart()
    {
        return $this->belongsTo(TestPart::class, 'test_part_id');
    }
}
