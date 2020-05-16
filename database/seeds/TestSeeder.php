<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tests')->insert([
            'user_id' => 1,
            'test_type_id' => 2,
            'name' => 'Practice Test 1',
            'time' => '60',
            'is_available' => 0
        ]);
    }
}
