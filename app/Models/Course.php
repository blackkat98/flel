<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Language;
use App\Models\Lesson;

class Course extends Model
{
    protected $table = 'courses';
    
    protected $fillable = [
        'user_id', 'language_id', 'name', 'code'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'course_id');
    }
}
