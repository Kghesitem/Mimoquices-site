<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdutoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        $produtos = [
            [
                'titulo'               => 'Agenda A5',
                'url_completo'         => 'Agenda A5-1',
                'tipo_prod'            => 1,
                'destaque'             => 0,
                'nome_original'        => '1-main.JPEG',
                'nome_cod'             => 'uploads/00dd7a8c9f7136761b4d0007a89521dd.jpg',
                'personalizar_opcoes'  => json_encode(["1","2","3","4","5"]),
                'descricao'            => "Única e totalmente personalizada! É simples e funcional e adequada para qualquer pessoa.\r\nA agenda apresenta-se nas versões com e sem horas e existem várias capas disponíveis que também pode personalizar.\r\nDe Janeiro a Dezembro de 2024",
                'conteudo'             => "Dados Pessoais\r\nPasswords\r\nContactos\r\nCalendários\r\nPlanificador Anual\r\nFolhas quadriculadas para notas\r\nSeparadores mensais com o nome de cada mês. O verso de cada separador contém prioridades, objetivos, notas e datas comemorativas.\r\nPlanificador Mensal\r\nVista semanal (2 páginas por semana)\r\nPáginas diferentes no final de cada mês.",
                'detalhes'             => "Capa dura em cartão\r\nPáginas interiores impressas, em alta qualidade, em papel de 90gr\r\n12 separadores mensais em papel fotográfico\r\nArgolas metálicas\r\nElástico preso com ilhós",
            ],
            [
                'titulo'               => 'Agenda A6',
                'url_completo'         => 'Agenda A6-2',
                'tipo_prod'            => 1,
                'destaque'             => 1,
                'nome_original'        => 'main.JPEG',
                'nome_cod'             => 'uploads/77a761372e41e490df2b1e724cc38e01.jpg',
                'personalizar_opcoes'  => json_encode(["1","2","3","4","5"]),
                'descricao'            => "Agenda leve para poder transportar na mala.\r\nA agenda apresenta-se nas versões com e sem horas e existem várias capas disponíveis que também pode personalizar.\r\nDe Janeiro a Dezembro de 2024",
                'conteudo'             => "Dados Pessoais\r\nPasswords\r\nAutomóvel\r\nConsultas\r\nCalendário 2024\r\nPlanificador Anual\r\nFolhas quadriculadas para notas\r\nSeparadores mensais com o nome de cada mês. O verso de cada separador contém prioridades, objetivos, notas e datas comemorativas.\r\nPlanificador Mensal\r\nVista semanal (2 páginas por semana)\r\nControlo financeiro",
                'detalhes'             => "Capa dura em cartão\r\nPáginas interiores impressas, em alta qualidade, em papel de 90gr\r\n12 separadores mensais em papel de 200gr\r\nArgolas metálicas\r\nElástico preso com ilhós",
            ],
            [
                'titulo'               => 'Chocolate',
                'url_completo'         => 'Chocolate-3',
                'tipo_prod'            => 2,
                'destaque'             => 0,
                'nome_original'        => 'Chocolate.jpg',
                'nome_cod'             => 'uploads/c423277cdef8fcf67e54d0936b0afc23.jpg',
                'personalizar_opcoes'  => json_encode(["6","7"]),
                'descricao'            => "Chocolate delicioso para oferecer a todos.",
                'conteudo'             => "500g de chocolate à sua escolha.\r\nEmbalagens variadas.",
                'detalhes'             => "Embalagem de alta qualidade\r\nChocolate artesanal\r\nValidade 6 meses",
            ]
        ];

        foreach ($produtos as &$produto) {
            $produto['disponivel']        = 1;
            $produto['pode_personalizar'] = 'Sim';
            $produto['created_at']        = $now;
            $produto['updated_at']        = $now;
        }
        unset($produto);

        DB::table('produto')->insert($produtos);
    }
}
