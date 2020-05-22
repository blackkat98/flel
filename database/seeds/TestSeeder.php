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
            'code' => 'dc04a6e9fb6709a79d985b36a7b50420',
            'time' => '60',
            'is_available' => 0
        ]);
    }
}
