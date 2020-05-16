<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\DefaultLanguage;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $default_languages = DefaultLanguage::toArray();

        // English (en) ID = 1
        // Tiếng Việt (vi) ID = 2
        foreach ($default_languages as $slug => $name) {
            DB::table('languages')->insert([
                'name' => $name,
                'slug' => $slug
            ]);
        }
    }
}
