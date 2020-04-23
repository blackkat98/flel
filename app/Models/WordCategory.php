<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Language;

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
}
