<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Course;

class Lesson extends Model
{
    protected $table = 'lessons';

    protected $fillable = [
    	'course_id', 'number', 'name', 'lecture', 'images', 'sound', 'video'
    ];

    protected $casts = [
    	'images' => 'array'
    ];

    public function course()
    {
    	return $this->belongsTo(Course::class, 'course_id');
    }
}
