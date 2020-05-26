<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Topic;

class Tag extends Model
{
    protected $table = 'tags';

    protected $fillable = [
        'topic_id', 'key'
    ];

    public function topic()
    {
        return $this->belongsTo(Topic::class, 'topic_id');
    }
}
