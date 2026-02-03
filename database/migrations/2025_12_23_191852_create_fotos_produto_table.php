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
            ['id' => 12, 'group_img' => 2, 'img_original' => 'IMG_8139.JPEG', 'img_cod' => 'uploads/849db6843197792d7254da00751b8819.jpg', 'created_at' => '2026-01-24 21:32:41', 'updated_at' => '2026-01-24 21:32:41'],
            ['id' => 13, 'group_img' => 2, 'img_original' => 'IMG_8137.JPEG', 'img_cod' => 'uploads/79103422965c723a0d27f4da5d84d706.jpg', 'created_at' => '2026-01-24 21:32:41', 'updated_at' => '2026-01-24 21:32:41'],
            ['id' => 14, 'group_img' => 2, 'img_original' => 'IMG_8133.JPEG', 'img_cod' => 'uploads/51c7277b6fb2fb2f05665046ac4f1fed.jpg', 'created_at' => '2026-01-24 21:32:41', 'updated_at' => '2026-01-24 21:32:41'],
            ['id' => 15, 'group_img' => 2, 'img_original' => 'IMG_8128.JPEG', 'img_cod' => 'uploads/7484417b000b95c2ddb3f82c50a136ca.jpg', 'created_at' => '2026-01-24 21:32:41', 'updated_at' => '2026-01-24 21:32:41'],
            ['id' => 16, 'group_img' => 2, 'img_original' => 'IMG_8123.JPEG', 'img_cod' => 'uploads/247ec8332bbfc003040640457cfff729.jpg', 'created_at' => '2026-01-24 21:32:41', 'updated_at' => '2026-01-24 21:32:41'],
            ['id' => 17, 'group_img' => 2, 'img_original' => 'IMG_8120.JPEG', 'img_cod' => 'uploads/a3ad02643aafe19c216aac0ee7bd27df.jpg', 'created_at' => '2026-01-24 21:32:41', 'updated_at' => '2026-01-24 21:32:41'],
            ['id' => 18, 'group_img' => 2, 'img_original' => 'IMG_8117.JPEG', 'img_cod' => 'uploads/0199c38ef537a9c30419e035e631669f.jpg', 'created_at' => '2026-01-24 21:32:41', 'updated_at' => '2026-01-24 21:32:41'],
            ['id' => 19, 'group_img' => 2, 'img_original' => 'IMG_8114.JPEG', 'img_cod' => 'uploads/526537de6a5de83221ee3f1246a00242.jpg', 'created_at' => '2026-01-24 21:32:41', 'updated_at' => '2026-01-24 21:32:41'],
            ['id' => 20, 'group_img' => 2, 'img_original' => 'IMG_8112.JPEG', 'img_cod' => 'uploads/d94bf184cddc0ae4054690a8155412e1.jpg', 'created_at' => '2026-01-24 21:32:41', 'updated_at' => '2026-01-24 21:32:41'],
            ['id' => 21, 'group_img' => 2, 'img_original' => 'IMG_8110.JPEG', 'img_cod' => 'uploads/ef78a738f21ce99e08bf7b9fd3af3541.jpg', 'created_at' => '2026-01-24 21:32:41', 'updated_at' => '2026-01-24 21:32:41'],
            ['id' => 22, 'group_img' => 2, 'img_original' => 'IMG_8108.JPEG', 'img_cod' => 'uploads/cba275638805a13803aeede79b146a1e.jpg', 'created_at' => '2026-01-24 21:32:41', 'updated_at' => '2026-01-24 21:32:41'],
            ['id' => 23, 'group_img' => 2, 'img_original' => 'IMG_7546.JPEG', 'img_cod' => 'uploads/f596f040ed245daebf64f4471289584c.jpg', 'created_at' => '2026-01-24 21:32:41', 'updated_at' => '2026-01-24 21:32:41'],
            ['id' => 24, 'group_img' => 1, 'img_original' => 'IMG_8078.JPEG', 'img_cod' => 'uploads/b139b99d429b37a390b3138896527318.jpg', 'created_at' => '2026-01-24 21:44:15', 'updated_at' => '2026-01-24 21:44:15'],
            ['id' => 25, 'group_img' => 1, 'img_original' => 'IMG_8182.JPEG', 'img_cod' => 'uploads/d6fed71a2eb74723c803617e7168686f.jpg', 'created_at' => '2026-01-24 21:44:15', 'updated_at' => '2026-01-24 21:44:15'],
            ['id' => 26, 'group_img' => 1, 'img_original' => 'IMG_8177.JPEG', 'img_cod' => 'uploads/453a9a690f2df0c656a8a152acc28745.jpg', 'created_at' => '2026-01-24 21:44:15', 'updated_at' => '2026-01-24 21:44:15'],
            ['id' => 27, 'group_img' => 1, 'img_original' => 'IMG_8175.JPEG', 'img_cod' => 'uploads/4112c98da7ef5aaad1e5bc79954272ea.jpg', 'created_at' => '2026-01-24 21:44:15', 'updated_at' => '2026-01-24 21:44:15'],
            ['id' => 28, 'group_img' => 1, 'img_original' => 'IMG_8103.JPEG', 'img_cod' => 'uploads/fc7b822d1705fd6b51b6a8a3c1b033b3.jpg', 'created_at' => '2026-01-24 21:44:15', 'updated_at' => '2026-01-24 21:44:15'],
            ['id' => 29, 'group_img' => 1, 'img_original' => 'IMG_8100.JPEG', 'img_cod' => 'uploads/cc9c6bd0e0cc3d2ceb6e4abc68d556ee.jpg', 'created_at' => '2026-01-24 21:44:15', 'updated_at' => '2026-01-24 21:44:15'],
            ['id' => 30, 'group_img' => 1, 'img_original' => 'IMG_8099.JPEG', 'img_cod' => 'uploads/03860c30d851dbd86a9292382a85bac8.jpg', 'created_at' => '2026-01-24 21:44:15', 'updated_at' => '2026-01-24 21:44:15'],
            ['id' => 31, 'group_img' => 1, 'img_original' => 'IMG_8098.JPEG', 'img_cod' => 'uploads/23caa38da4b12beea7931af586cf49cf.jpg', 'created_at' => '2026-01-24 21:44:16', 'updated_at' => '2026-01-24 21:44:16'],
            ['id' => 32, 'group_img' => 1, 'img_original' => 'IMG_8095.JPEG', 'img_cod' => 'uploads/4de7cc7f018d32f0a0d813ab6ecbf671.jpg', 'created_at' => '2026-01-24 21:44:16', 'updated_at' => '2026-01-24 21:44:16'],
            ['id' => 33, 'group_img' => 1, 'img_original' => 'IMG_8092.JPEG', 'img_cod' => 'uploads/eb3fdd60051eb802c520a0b1b04c5a50.jpg', 'created_at' => '2026-01-24 21:44:16', 'updated_at' => '2026-01-24 21:44:16'],
            ['id' => 34, 'group_img' => 1, 'img_original' => 'IMG_8090.JPEG', 'img_cod' => 'uploads/8cb54b179a27a5c5d1423d0abb77bc94.jpg', 'created_at' => '2026-01-24 21:44:16', 'updated_at' => '2026-01-24 21:44:16'],
            ['id' => 35, 'group_img' => 1, 'img_original' => 'IMG_8088.JPEG', 'img_cod' => 'uploads/d5b332ed993a0c5092fc148cf4e858cb.jpg', 'created_at' => '2026-01-24 21:44:16', 'updated_at' => '2026-01-24 21:44:16'],
            ['id' => 36, 'group_img' => 1, 'img_original' => 'IMG_8086.JPEG', 'img_cod' => 'uploads/8d4e46184d6da5b3a3930604a8644061.jpg', 'created_at' => '2026-01-24 21:44:16', 'updated_at' => '2026-01-24 21:44:16'],
        

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
