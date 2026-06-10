<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FotosProdutoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dados = [
            1 => [
                ['orig' => 'IMG_8078.JPEG', 'cod' => 'uploads/de15db6d8eb798394deeb3bdb08ffdf4.jpg'],
                ['orig' => 'IMG_8080.JPEG', 'cod' => 'uploads/d2c23f47ec1e1d5874ff5caba7c377ad.jpg'],
                ['orig' => 'IMG_8082.JPEG', 'cod' => 'uploads/3fd1c39bbc53a3080b777b781e55fcb3.jpg'],
                ['orig' => 'IMG_8088.JPEG', 'cod' => 'uploads/124ce2da7a888ddc47144e75ce512c10.jpg'],
                ['orig' => 'IMG_8090.JPEG', 'cod' => 'uploads/1d09e66e7eb7fed9aef0446ae47789a4.jpg'],
                ['orig' => 'IMG_8095.JPEG', 'cod' => 'uploads/d06a107656d2c54204c393db73043650.jpg'],
                ['orig' => 'IMG_8099.JPEG', 'cod' => 'uploads/04ff47956bf821c135a721a37d1bf3c3.jpg'],
                ['orig' => 'IMG_8100.JPEG', 'cod' => 'uploads/c322b3a4ec34ef7092c4b0dc61279278.jpg'],
                ['orig' => 'IMG_8103.JPEG', 'cod' => 'uploads/2cfb9b7f8874fd4feb61411baa56f916.jpg'],
                ['orig' => 'IMG_8175.JPEG', 'cod' => 'uploads/d2fef56a2bc3866d21717f17122da91f.jpg'],
                ['orig' => 'IMG_8177.JPEG', 'cod' => 'uploads/e1af21f33c983c82163855f0a7f935ed.jpg'],
                ['orig' => 'IMG_8182.JPEG', 'cod' => 'uploads/69f71a4fc20d34b3df7febe1795f7ca5.jpg'],
            ],
            2 => [
                ['orig' => 'IMG_8139.JPEG', 'cod' => 'uploads/16d24ba4673f7b2695540b8ffae8e3c3.jpg'],
                ['orig' => 'IMG_8137.JPEG', 'cod' => 'uploads/ddf9789bb05cfdf0e1142966a47e4db0.jpg'],
                ['orig' => 'IMG_8133.JPEG', 'cod' => 'uploads/0e415a4eb8fd09fd962f1638a3248769.jpg'],
                ['orig' => 'IMG_8128.JPEG', 'cod' => 'uploads/a9396dc1f362d925035cfa8ad8c17dce.jpg'],
                ['orig' => 'IMG_8123.JPEG', 'cod' => 'uploads/8ca4f6bad4adbe945d5875c56a421312.jpg'],
                ['orig' => 'IMG_8110.JPEG', 'cod' => 'uploads/757a9987a9738e940860d1c8e7cf797b.jpg'],
                ['orig' => 'IMG_8108.JPEG', 'cod' => 'uploads/f32604aeb31582c96a13dd729d08b849.jpg'],
                ['orig' => 'IMG_7546.JPEG', 'cod' => 'uploads/a361343146ebe6cc9fc9fa1f9dd7d413.jpg'],
            ]
        ];

        $insertData = [];
        $now = now();

        foreach ($dados as $groupImg => $fotos) {
            foreach ($fotos as $foto) {
                $insertData[] = [
                    'group_img'    => $groupImg,
                    'img_original' => $foto['orig'],
                    'img_cod'      => $foto['cod'],
                    'created_at'   => $now,
                    'updated_at'   => $now,
                ];
            }
        }

        DB::table('fotos_produto')->insert($insertData);
    }
}
