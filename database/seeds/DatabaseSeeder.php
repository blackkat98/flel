<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CourseSeeder::class);
        $this->call(LanguageSeeder::class);
        $this->call(LessonSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(TestSeeder::class);
        $this->call(TestTypeSeeder::class);
        $this->call(TestTypeRuleSeeder::class);
        $this->call(UserHasRoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(WordCategorySeeder::class);
    }
}
