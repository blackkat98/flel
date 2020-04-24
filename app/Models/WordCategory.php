<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Language;
use App\Models\Word;

class WordCategory extends Model
{
    protected $table = 'word_categories';

    protected $fillable = [
        'language_id', 'name'
    ];

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    public function words()
    {
        return $this->hasMany(Word::class, 'word_category_id');
    }
}
