<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RespostasSeeder extends Seeder
{
    public function run(): void
    {
        $dados = [
            6 => ['Chocolate negro', 'Chocolate branco', 'Chocolate com leite'],
            5 => ['🩶 Prateado', '💛 Dourado', '🖤 Preto', '🧡 Cobre'],
            4 => ['Metálico', 'Acrílico'],
            3 => ['Prestação de Serviços', 'Assuntos a Tratar', 'As Minhas Notas', 'Controlo Financeiro'],
            2 => ['Com horas', 'Com linhas sem horas', 'Sem horas', 'Semanal dividida', 'Semanal "em caixa"', 'Semanal com horas', 'Unissexo'],
        ];

        $insertData = [];
        $now = now();

        foreach ($dados as $idPersonalizacao => $respostas) {
            foreach ($respostas as $resposta) {
                $insertData[] = [
                    'id_personalizacao' => $idPersonalizacao,
                    'resposta'          => $resposta,
                    'created_at'        => $now,
                    'updated_at'        => $now,
                ];
            }
        }

        DB::table('respostas')->insert($insertData);
    }
}
