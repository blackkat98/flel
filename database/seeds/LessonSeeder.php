<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('lessons')->insert([
            'course_id' => 1,
            'number' => 1,
            'name' => 'Introduction',
            'lecture' => 'This tense is used to describe a regular action, a habit or the inevitable. (This is a seeded data row.)'
        ]);

        DB::table('lessons')->insert([
            'course_id' => 1,
            'number' => 2,
            'name' => 'Structure',
            'lecture' => 'S + V(bare-infinitive) + preposition + O. (This is a seeded data row.)'
        ]);

        DB::table('lessons')->insert([
            'course_id' => 1,
            'number' => 3,
            'name' => 'Example',
            'lecture' => 'I go to school everyday. (This is a seeded data row.)'
        ]);
    }
}
