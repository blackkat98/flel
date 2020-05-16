<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserHasRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model_type = 'App\Models\User';

        DB::table('model_has_roles')->insert([
            'model_type' => $model_type,
            'role_id' => 1,
            'model_id' => 1
        ]);

        DB::table('model_has_roles')->insert([
            'model_type' => $model_type,
            'role_id' => 1,
            'model_id' => 2
        ]);

        DB::table('model_has_roles')->insert([
            'model_type' => $model_type,
            'role_id' => 2,
            'model_id' => 3
        ]);

        DB::table('model_has_roles')->insert([
            'model_type' => $model_type,
            'role_id' => 1,
            'model_id' => 4
        ]);

        DB::table('model_has_roles')->insert([
            'model_type' => $model_type,
            'role_id' => 2,
            'model_id' => 5
        ]);

        DB::table('model_has_roles')->insert([
            'model_type' => $model_type,
            'role_id' => 3,
            'model_id' => 6
        ]);
    }
}
