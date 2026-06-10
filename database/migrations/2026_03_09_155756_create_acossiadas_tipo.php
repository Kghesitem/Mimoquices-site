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
        Schema::create('acossiadas_tipo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_tipo');
            $table->unsignedBigInteger('id_todas');
            $table->timestamps();
            $table->foreign('id_tipo')->references('id')->on('tipo')->onupdate('cascade')->onDelete('cascade');
            $table->foreign('id_todas')->references('id')
                ->on('todas_as_personalizacoes')->onupdate('cascade')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acossiadas_tipo');
    }
};
