<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Language;

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
}
