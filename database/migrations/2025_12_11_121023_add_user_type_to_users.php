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
        Schema::table('users', function (Blueprint $table) {
            $table->string('user_type')->after('name')->default('user');
            $table->boolean('newsletter')->after('user_type')->default(false);
        });

        DB::table('users')->insert([
            [
                'name'=> 'a',
                'user_type' => 'admin',
                'email' => 'a@gmail.com',
                'email_verified_at' => now(),
                'password' => '$2y$12$CuLZ6SVdsW0w5Drr.xt.Vu3lRvw2xB0usFdIr4Ey97oxmUvdjRWLe',
                'newsletter' => true,
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
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
