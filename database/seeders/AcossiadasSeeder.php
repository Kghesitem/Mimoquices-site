<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcossiadasSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Mapeamento limpo: id_tipo => [lista de id_todas]
        $dados = [
            1 => [1, 2, 3, 4, 5],
            2 => [6, 7],
        ];

        $insertData = [];
        $now = now();

        // 2. Construção dinâmica do array estruturado
        foreach ($dados as $idTipo => $idsTodas) {
            foreach ($idsTodas as $idTodas) {
                $insertData[] = [
                    'id_tipo'    => $idTipo,
                    'id_todas'   => $idTodas,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        // 3. Inserção em massa (Bulk Insert)
        DB::table('acossiadas_tipo')->insert($insertData);
    }
}
