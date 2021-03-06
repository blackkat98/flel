<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Language;
use App\Models\Test;
use App\Models\TestTypeRule;

class TestType extends Model
{
    protected $table = 'test_types';

    protected $fillable = [
        'language_id', 'name', 'slug', 'description', 'fixed_quiz_quantity', 'fixed_parts', 'fixed_time', 'is_available'
    ];

    protected $casts = [
        'fixed_parts' => 'array'
    ];

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    public function tests()
    {
        return $this->hasMany(Test::class, 'test_type_id');
    }

    public function testTypeRule()
    {
        return $this->hasOne(TestTypeRule::class, 'test_type_id');
    }
}
