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
        Schema::create('fotos_produto', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_img');
            $table->string('img_original');
            $table->string('img_cod');
            $table->timestamps();
            $table->foreign('group_img', 'fk_produto_fotos')->references('id')->on('produto')->onDelete('cascade')->onUpdate('cascade');
        });
        DB::table('fotos_produto')->insert([
    [
        'group_img' => 1,
        'img_original' => 'IMG_8078.JPEG',
        'img_cod' => 'uploads/de15db6d8eb798394deeb3bdb08ffdf4.jpg',
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'group_img' => 1,
        'img_original' => 'IMG_8080.JPEG',
        'img_cod' => 'uploads/d2c23f47ec1e1d5874ff5caba7c377ad.jpg',
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'group_img' => 1,
        'img_original' => 'IMG_8082.JPEG',
        'img_cod' => 'uploads/3fd1c39bbc53a3080b777b781e55fcb3.jpg',
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'group_img' => 1,
        'img_original' => 'IMG_8088.JPEG',
        'img_cod' => 'uploads/124ce2da7a888ddc47144e75ce512c10.jpg',
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'group_img' => 1,
        'img_original' => 'IMG_8090.JPEG',
        'img_cod' => 'uploads/1d09e66e7eb7fed9aef0446ae47789a4.jpg',
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'group_img' => 1,
        'img_original' => 'IMG_8095.JPEG',
        'img_cod' => 'uploads/d06a107656d2c54204c393db73043650.jpg',
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'group_img' => 1,
        'img_original' => 'IMG_8099.JPEG',
        'img_cod' => 'uploads/04ff47956bf821c135a721a37d1bf3c3.jpg',
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'group_img' => 1,
        'img_original' => 'IMG_8100.JPEG',
        'img_cod' => 'uploads/c322b3a4ec34ef7092c4b0dc61279278.jpg',
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'group_img' => 1,
        'img_original' => 'IMG_8103.JPEG',
        'img_cod' => 'uploads/2cfb9b7f8874fd4feb61411baa56f916.jpg',
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'group_img' => 1,
        'img_original' => 'IMG_8175.JPEG',
        'img_cod' => 'uploads/d2fef56a2bc3866d21717f17122da91f.jpg',
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'group_img' => 1,
        'img_original' => 'IMG_8177.JPEG',
        'img_cod' => 'uploads/e1af21f33c983c82163855f0a7f935ed.jpg',
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'group_img' => 1,
        'img_original' => 'IMG_8182.JPEG',
        'img_cod' => 'uploads/69f71a4fc20d34b3df7febe1795f7ca5.jpg',
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'group_img' => 2,
        'img_original' => 'IMG_8139.JPEG',
        'img_cod' => 'uploads/16d24ba4673f7b2695540b8ffae8e3c3.jpg',
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'group_img' => 2,
        'img_original' => 'IMG_8137.JPEG',
        'img_cod' => 'uploads/ddf9789bb05cfdf0e1142966a47e4db0.jpg',
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'group_img' => 2,
        'img_original' => 'IMG_8133.JPEG',
        'img_cod' => 'uploads/0e415a4eb8fd09fd962f1638a3248769.jpg',
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'group_img' => 2,
        'img_original' => 'IMG_8128.JPEG',
        'img_cod' => 'uploads/a9396dc1f362d925035cfa8ad8c17dce.jpg',
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'group_img' => 2,
        'img_original' => 'IMG_8123.JPEG',
        'img_cod' => 'uploads/8ca4f6bad4adbe945d5875c56a421312.jpg',
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'group_img' => 2,
        'img_original' => 'IMG_8110.JPEG',
        'img_cod' => 'uploads/757a9987a9738e940860d1c8e7cf797b.jpg',
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'group_img' => 2,
        'img_original' => 'IMG_8108.JPEG',
        'img_cod' => 'uploads/f32604aeb31582c96a13dd729d08b849.jpg',
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'group_img' => 2,
        'img_original' => 'IMG_7546.JPEG',
        'img_cod' => 'uploads/a361343146ebe6cc9fc9fa1f9dd7d413.jpg',
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
        Schema::dropIfExists('fotos_produto');
    }
};
