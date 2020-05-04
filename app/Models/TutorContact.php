<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Language;

class TutorContact extends Model
{
    protected $table = 'tutor_contacts';

    protected $fillable = [
        'name', 'image', 'email', 'phone', 'extra', 'location', 'is_occupied'
    ];

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
