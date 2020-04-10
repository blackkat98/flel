<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Language;
use App\Models\Test;

class TestType extends Model
{
    protected $table = 'test_types';
    
    protected $fillable = [
        'language_id', 'name', 'description'
    ];
    
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
    
    public function tests()
    {
        return $this->hasMany(Test::class, 'test_type_id');
    }
}
