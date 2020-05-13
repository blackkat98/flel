<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TestType;

class TestTypeRule extends Model
{
    protected $table = 'test_type_rules';

    protected $fillable = [
        'test_type_id', 'score_rule_type', 'score_rules', 'extra'
    ];

    protected $casts = [
        'score_rules' => 'array'
    ];

    public function testType()
    {
        return $this->belongsTo(TestType::class, 'test_type_id');
    }
}
