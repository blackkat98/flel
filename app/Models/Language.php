<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Course;
use App\Models\TestType;
use App\Models\WordCategory;

class Language extends Model
{
    protected $table = 'languages';
    
    protected $fillable = [
        'name', 'slug'
    ];
    
    public function courses()
    {
        return $this->hasMany(Course::class, 'language_id');
    }
    
    public function testTypes()
    {
        return $this->hasMany(TestType::class, 'language_id');
    }

    public function wordCategories()
    {
        return $this->hasMany(WordCategory::class, 'language_id');
    }
}
