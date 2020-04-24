<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\WordCategory;

class Word extends Model
{
    protected $table = 'words';

    protected $fillable = [
        'word_category_id', 'word', 'definition', 'example', 'ipa', 'pronounciation'
    ];

    public function wordCategory()
    {
        return $this->belongsTo(WordCategory::class, 'word_category_id');
    }
}
