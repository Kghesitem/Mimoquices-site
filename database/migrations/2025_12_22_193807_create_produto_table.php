<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produto', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descricao');
            $table->text('conteudo')->nullable();
            $table->text('detalhes')->nullable();
            $table->string('url_completo');
            $table->unsignedBigInteger('tipo_prod');
            $table->string('nome_original');
            $table->boolean('disponivel')->default(true);
            $table->boolean('destaque')->default(false);
            $table->string('nome_cod');
            $table->string('pode_personalizar')->default('Não');
            $table->longText('personalizar_opcoes')->nullable();
            $table->timestamps();
        });

        // Índice estrangeiro
        Schema::table('produto', function (Blueprint $table) {
            $table->foreign('tipo_prod')->references('id')->on('tipo');
        });


    }

    public function down(): void
    {
        Schema::dropIfExists('produto');
    }
};
