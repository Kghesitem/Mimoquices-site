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
            $table->string('url_completo');
            $table->unsignedBigInteger('tipo_prod');
            $table->string('nome_original');
            $table->string('nome_cod');
            $table->foreign('tipo_prod', 'fk_produto_tipo')->references('id')->on('tipo')->onDelete('restrict')->onUpdate('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produto');
        Schema::table('produto', function (Blueprint $table) {
            $table->dropForeign(['tipo_prod']);
            $table->dropForeign(['group_img']);
    });
    }
};
