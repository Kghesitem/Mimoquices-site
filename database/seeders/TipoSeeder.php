<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('tipo')->insert([
        [
            'Categoria' => 'Papelaria',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'Categoria' => 'Docinhos',
            'created_at' => now(),
            'updated_at' => now(),
        ]
    ]);
    }
}
