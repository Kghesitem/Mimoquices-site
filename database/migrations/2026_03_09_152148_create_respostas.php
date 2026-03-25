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
        Schema::create('respostas', function (Blueprint $table) {
            $table->id();
    $table->unsignedBigInteger('id_personalizacao');
    $table->string('resposta');

    $table->foreign('id_personalizacao')
          ->references('id')
          ->on('todas_as_personalizacoes')
          ->onDelete('cascade')
          ->onUpdate('cascade');

    $table->timestamps();
        });

        DB::table('respostas')->insert([
        [
            'id_personalizacao' => 6,
            'resposta' => 'Chocolate negro',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'id_personalizacao' => 6,
            'resposta' => 'Chocolate branco',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'id_personalizacao' => 6,
            'resposta' => 'Chocolate com leite',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'id_personalizacao' => 5,
            'resposta' => '🩶 Prateado',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'id_personalizacao' => 5,
            'resposta' => '💛 Dourado',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'id_personalizacao' => 5,
            'resposta' => '🖤 Preto',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'id_personalizacao' => 5,
            'resposta' => '🧡 Cobre',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'id_personalizacao' => 4,
            'resposta' => 'Metálico',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'id_personalizacao' => 4,
            'resposta' => 'Acrílico',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'id_personalizacao' => 3,
            'resposta' => 'Prestação de Serviços',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'id_personalizacao' => 3,
            'resposta' => 'Assuntos a Tratar',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'id_personalizacao' => 3,
            'resposta' => 'As Minhas Notas',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'id_personalizacao' => 3,
            'resposta' => 'Controlo Financeiro',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'id_personalizacao' => 2,
            'resposta' => 'Com horas',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'id_personalizacao' => 2,
            'resposta' => 'Com linhas sem horas',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'id_personalizacao' => 2,
            'resposta' => 'Sem horas',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'id_personalizacao' => 2,
            'resposta' => 'Semanal dividida',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'id_personalizacao' => 2,
            'resposta' => 'Semanal "em caixa"',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'id_personalizacao' => 2,
            'resposta' => 'Semanal com horas',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'id_personalizacao' => 2,
            'resposta' => 'Unissexo',
            'created_at' => now(),
            'updated_at' => now()
        ],
    ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respostas');
    }
};
