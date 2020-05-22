<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('test_types')->insert([
            'language_id' => 1,
            'name' => 'Toeic',
            'slug' => 'toeic',
            'fixed_quiz_quantity' => 200,
            'fixed_parts' => json_encode(['Listening', 'Reading']),
            'fixed_time' => '120',
            'is_available' => 0,
            'description' => 'This is a seeded data row'
        ]);

        DB::table('test_types')->insert([
            'language_id' => 1,
            'name' => 'Self Test',
            'slug' => 'self-test',
            'fixed_quiz_quantity' => 0,
            'fixed_parts' => json_encode(['Default']),
            'fixed_time' => 0,
            'is_available' => 1,
            'description' => 'This is a seeded data row'
        ]);
    }
}
