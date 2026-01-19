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
        Schema::create('personalizacaos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_produto');
            $table->unsignedBigInteger('id_pedido');
            $table->string('personalizacao_pedida');
            $table->string('opcoes_selecionadas');
            $table->timestamps();
            $table->foreign('id_pedido', 'fk_pedido_personalizacao')->references('id')->on('pedido')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_produto', 'fk_produto_personalizacao')->references('id')->on('produto')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personalizacaos');
    }
};
