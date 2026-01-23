<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
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
            $table->boolean('disponivel')->default(1);
            $table->string('nome_cod');
            $table->foreign('tipo_prod', 'fk_produto_tipo')->references('id')->on('tipo')->onDelete('restrict')->onUpdate('restrict');
            $table->timestamps();
        });
        Schema::table('produto', function (Blueprint $table) {
            $table->string('pode_personalizar')->nullable()->default('Não');
            $table->json('personalizar_opcoes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produto', function (Blueprint $table) {
            $table->dropForeign(['tipo_prod']);
        });
        Schema::dropIfExists('produto');
        Schema::table('produto', function (Blueprint $table) {
            $table->dropColumn(['pode_personalizar', 'personalizar_opcoes']);
        });
    }
};
