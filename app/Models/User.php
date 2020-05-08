<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Course;
use App\Models\Test;
use App\Models\UserTest;
use App\Models\UserCourse;
use App\Models\TutorContact;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function courses()
    {
        return $this->hasMany(Course::class, 'user_id');
    }

    public function tests()
    {
        return $this->hasMany(Test::class, 'user_id');
    }

    public function userTests()
    {
        return $this->hasMany(UserTest::class, 'user_id');
    }

    public function userCourses()
    {
        return $this->hasMany(UserCourse::class, 'user_id');
    }

    public function tutorContact()
    {
        return $this->hasOne(TutorContact::class, 'user_id');
    }
}
