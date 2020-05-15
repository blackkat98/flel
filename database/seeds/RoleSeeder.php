<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\DefaultUserRole;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $default_roles = array_flip(DefaultUserRole::toArray());

        foreach ($default_roles as $key => $value) {
            DB::table('roles')->insert([
                'name' => $value,
                'guard_name' => 'web'
            ]);
        }
    }
}
