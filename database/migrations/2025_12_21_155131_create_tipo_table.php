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
        Schema::create('tipo', function (Blueprint $table) {
            $table->id();
            $table->string('Categoria');
            $table->timestamps();
        });
        DB::table('tipo')->insert([
        [
            'Categoria' => 'Papelaria',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'Categoria' => 'Docinhos',
            'created_at' => now(),
            'updated_at' => now(),
        ]
    ]);
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo');
    }
};
