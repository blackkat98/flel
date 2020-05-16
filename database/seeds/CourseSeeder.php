<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('courses')->insert([
            'user_id' => 1,
            'language_id' => 1,
            'name' => 'Simple Present Course 1',
            'description' => 'This is a seeded data row',
            'code' => 'en-1',
            'is_available' => 0
        ]);
    }
}
