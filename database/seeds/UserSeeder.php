<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'nam',
            'email' => 'nam.th.200698@gmail.com',
            'image' => 'img/user.png',
            'password' => Hash::make('062098')
        ]);

        DB::table('users')->insert([
            'name' => 'trang',
            'email' => 'tanghuyentrangit1998@gmail.com',
            'image' => 'img/user.png',
            'password' => Hash::make('090698')
        ]);

        DB::table('users')->insert([
            'name' => 'blackkat',
            'email' => 'tonymckiller@gmail.com',
            'image' => 'img/user.png',
            'password' => Hash::make('111111')
        ]);

        DB::table('users')->insert([
            'name' => 'root',
            'email' => 'flelroot@gmail.com',
            'image' => 'img/user.png',
            'password' => Hash::make('111111')
        ]);

        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'fleladmin@gmail.com',
            'image' => 'img/user.png',
            'password' => Hash::make('111111')
        ]);

        DB::table('users')->insert([
            'name' => 'editor',
            'email' => 'fleleditor@gmail.com',
            'image' => 'img/user.png',
            'password' => Hash::make('111111')
        ]);

        DB::table('users')->insert([
            'name' => 'sampleuser',
            'email' => 'flelsampleuser@gmail.com',
            'image' => 'img/user.png',
            'password' => Hash::make('111111')
        ]);
    }
}
