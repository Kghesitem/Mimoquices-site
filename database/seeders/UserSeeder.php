<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name'=> 'admin',
                'user_type' => 'admin',
                'email' => 'a@gmail.com',
                'email_verified_at' => now(),
                'password' => '$2y$12$CuLZ6SVdsW0w5Drr.xt.Vu3lRvw2xB0usFdIr4Ey97oxmUvdjRWLe',
                'newsletter' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'=> 'user',
                'user_type' => 'user',
                'email' => 'user@gmail.com',
                'email_verified_at' => now(),
                'password' => '$2y$12$CuLZ6SVdsW0w5Drr.xt.Vu3lRvw2xB0usFdIr4Ey97oxmUvdjRWLe',
                'newsletter' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
