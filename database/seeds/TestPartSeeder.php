<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestPartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('test_parts')->insert([
            'test_id' => 1,
            'name' => 'Default'
        ]);
    }
}
