<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TestType;
use App\Models\TestPart;

class Test extends Model
{
    protected $table = 'tests';
    
    protected $fillable = [
        'user_id', 'test_type_id', 'name', 'time'
    ];
    
    public function testType()
    {
        return $this->belongsTo(TestType::class, 'test_type_id');
    }
    
    public function testParts()
    {
        return $this->hasMany(TestPart::class, 'test_id');
    }
}
