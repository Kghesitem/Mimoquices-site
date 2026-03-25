<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('todas_as_personalizacoes', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descricao');
            $table->string('tipo_de_input');
            $table->string('PDF')->nullable();
            $table->timestamps();
        });

        DB::table('todas_as_personalizacoes')->insert([
        [
            'titulo' => '📝 Texto da Capa',
            'descricao'=> 'Permitir que o cliente escreva um texto personalizado na capa',
            'tipo_de_input'=>'texto',
            'PDF'=> null,
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'titulo' => '📅 Formato da Agenda',
            'descricao'=> 'Permitir que o cliente escolha entre uma coleção que define o formato da agenda',
            'tipo_de_input'=>'select',
            'PDF'=> 'pdfs/KIofQiTApy5frHyyVE8dsvNfFSoRanlyIoUDsDKN.pdf',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'titulo' => '📄 Páginas Especiais',
            'descricao'=> 'Permitir que o cliente selecione páginas adicionais especiais',
            'tipo_de_input'=>'checkbox',
            'PDF'=> 'pdfs/YqX1qfSmLWvtkJPbsTZq9BYdhtQE8bi5TQIEXWzy.pdf',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'titulo' => '⭕ Acessório do Elástico',
            'descricao'=> 'Permitir que o cliente escolha entre "Metálico" e outras opções disponíveis',
            'tipo_de_input'=>'select',
            'PDF'=> null,
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'titulo' => '🎨 Cor das Argolas',
            'descricao'=> 'Permitir que o cliente selecione entre Prateado, Dourado e outras cores disponíveis',
            'tipo_de_input'=>'select',
            'PDF'=> null,
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'titulo' => '🍫 Tipo de Chocolate',
            'descricao'=> 'Permitir escolher entre Chocolate negro, Chocolate de leite e Chocolate branco',
            'tipo_de_input'=>'select',
            'PDF'=> null,
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'titulo' => '📝 Nome na embalagem',
            'descricao'=> 'Permitir que o cliente escreva um texto personalizado para a embalagem',
            'tipo_de_input'=>'texto',
            'PDF'=> null,
            'created_at' => now(),
            'updated_at' => now()
        ]
    ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todas_as_personalizacoes');
    }


    


};
