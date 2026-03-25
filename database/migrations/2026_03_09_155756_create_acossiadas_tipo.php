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
        DB::table('acossiadas_tipo')->insert([
        [
            'id_tipo' => 1,
            'id_todas' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'id_tipo' => 1,
            'id_todas' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'id_tipo' => 1,
            'id_todas' => 3,
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'id_tipo' => 1,
            'id_todas' => 4,
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'id_tipo' => 1,
            'id_todas' => 5,
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'id_tipo' => 2,
            'id_todas' => 6,
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'id_tipo' => 2,
            'id_todas' => 7,
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
        Schema::dropIfExists('acossiadas_tipo');
    }
};
