<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Language;
use App\Models\User;

class TutorContact extends Model
{
    protected $table = 'tutor_contacts';

    protected $fillable = [
        'user_id', 'language_id', 'real_name', 'phone', 'social_networks', 'experiences', 'location'
    ];

    protected $casts = [
    	'social_networks' => 'array'
    ];

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
