<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TodasAsPersonalizacoesSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $personalizacoes = [
            [
                'titulo'        => '📝 Texto da Capa',
                'descricao'     => 'Permitir que o cliente escreva um texto personalizado na capa',
                'tipo_de_input' => 'texto',
                'PDF'           => null,
            ],
            [
                'titulo'        => '📅 Formato da Agenda',
                'descricao'     => 'Permitir que o cliente escolha entre uma coleção que define o formato da agenda',
                'tipo_de_input' => 'select',
                'PDF'           => 'pdfs/KIofQiTApy5frHyyVE8dsvNfFSoRanlyIoUDsDKN.pdf',
            ],
            [
                'titulo'        => '📄 Páginas Especiais',
                'descricao'     => 'Permitir que o cliente selecione páginas adicionais especiais',
                'tipo_de_input' => 'checkbox',
                'PDF'           => 'pdfs/YqX1qfSmLWvtkJPbsTZq9BYdhtQE8bi5TQIEXWzy.pdf',
            ],
            [
                'titulo'        => '⭕ Acessório do Elástico',
                'descricao'     => 'Permitir que o cliente escolha entre "Metálico" e outras opções disponíveis',
                'tipo_de_input' => 'select',
                'PDF'           => null,
            ],
            [
                'titulo'        => '🎨 Cor das Argolas',
                'descricao'     => 'Permitir que o cliente selecione entre Prateado, Dourado e outras cores disponíveis',
                'tipo_de_input' => 'select',
                'PDF'           => null,
            ],
            [
                'titulo'        => '🍫 Tipo de Chocolate',
                'descricao'     => 'Permitir escolher entre Chocolate negro, Chocolate de leite e Chocolate branco',
                'tipo_de_input' => 'select',
                'PDF'           => null,
            ],
            [
                'titulo'        => '📝 Nome na embalagem',
                'descricao'     => 'Permitir que o cliente escreva um texto personalizado para a embalagem',
                'tipo_de_input' => 'texto',
                'PDF'           => null,
            ],
        ];

        foreach ($personalizacoes as &$item) {
            $item['created_at'] = $now;
            $item['updated_at'] = $now;
        }
        unset($item);

        DB::table('todas_as_personalizacoes')->insert($personalizacoes);
    }
}
