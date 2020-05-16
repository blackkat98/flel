<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WordCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('word_categories')->insert([
            'language_id' => 1,
            'name' => 'Everyday Life'
        ]);

        DB::table('word_categories')->insert([
            'language_id' => 1,
            'name' => 'Office'
        ]);

        DB::table('word_categories')->insert([
            'language_id' => 1,
            'name' => 'Market'
        ]);

        DB::table('word_categories')->insert([
            'language_id' => 1,
            'name' => 'Economy'
        ]);

        DB::table('word_categories')->insert([
            'language_id' => 1,
            'name' => 'School'
        ]);
    }
}
