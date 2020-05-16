<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestTypeRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('test_type_rules')->insert([
            'test_type_id' => 2,
            'score_rule_type' => 0,
            'score_rules' => json_encode([
                'Default' => [
                    '250' => 1
                ]
            ])
        ]);
    }
}
