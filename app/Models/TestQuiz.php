<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TestPart;

class TestQuiz extends Model
{
    protected $table = 'test_quizzes';
    
    protected $fillable = [
        'test_part_id', 'number', 'associated_quiz_id', 'quiz_type', 'question', 'options', 'answer', 'images', 'sound', 'video'
    ];
    
    protected $casts = [
        'options' => 'array',
        'answer' => 'array',
        'images' => 'array'
    ];


    public function testPart()
    {
        return $this->belongsTo(TestPart::class, 'test_part_id');
    }

    public function getAssociatedNumber()
    {
        if ($this->associated_quiz_id == 0) {
            return 0;
        }

        $associated_quiz = self::findOrFail($this->associated_quiz_id);

        return $associated_quiz->number;
    }
}
