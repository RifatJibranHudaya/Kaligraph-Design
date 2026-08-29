<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class NeonBoxProductSeeder extends Seeder
{
    /**
     * Seed neon box products for Kaligraph Design.
     */
    public function run(): void
    {
        Product::truncate();

        $products = [
            [
                'nama'          => 'Neon Box Akrilik',
                'harga_min'     => 350000,
                'harga_max'     => 750000,
                'harga_default' => 350000,
                'deskripsi'     => 'Neon box akrilik transparan dengan pencahayaan LED merata. Cocok untuk papan nama toko, restoran, salon, dan klinik. Tersedia berbagai ukuran custom.',
                'urutan'        => 1,
                'is_active'     => true,
            ],
            [
                'nama'          => 'Neon Box Flexy',
                'harga_min'     => 280000,
                'harga_max'     => 500000,
                'harga_default' => 280000,
                'deskripsi'     => 'Neon box berbahan flexy (baliho) dengan rangka box aluminium kuat. Harga lebih terjangkau dengan hasil cetak full color berkualitas tinggi.',
                'urutan'        => 2,
                'is_active'     => true,
            ],
            [
                'nama'          => 'Neon Box LED Bulat',
                'harga_min'     => 450000,
                'harga_max'     => 900000,
                'harga_default' => 450000,
                'deskripsi'     => 'Neon box bentuk bulat/oval dengan pencahayaan LED. Desain unik yang menarik perhatian, ideal untuk branding premium dan restoran modern.',
                'urutan'        => 3,
                'is_active'     => true,
            ],
            [
                'nama'          => 'Neon Box LED Kotak',
                'harga_min'     => 320000,
                'harga_max'     => 650000,
                'harga_default' => 320000,
                'deskripsi'     => 'Neon box kotak standar dengan LED strip di dalam. Cahaya terang merata dan hemat listrik. Tahan cuaca untuk penggunaan indoor maupun outdoor.',
                'urutan'        => 4,
                'is_active'     => true,
            ],
            [
                'nama'          => 'Huruf Timbul LED',
                'harga_min'     => 250000,
                'harga_max'     => 600000,
                'harga_default' => 250000,
                'deskripsi'     => 'Huruf timbul 3D dengan material akrilik atau stainless steel, dilengkapi LED dari belakang (backlit) atau dalam. Kesan premium dan elegan.',
                'urutan'        => 5,
                'is_active'     => true,
            ],
            [
                'nama'          => 'Backlit Signage',
                'harga_min'     => 400000,
                'harga_max'     => 850000,
                'harga_default' => 400000,
                'deskripsi'     => 'Papan signage dengan pencahayaan dari belakang. Sangat efektif untuk mall, hotel, perkantoran, dan fasad gedung komersial.',
                'urutan'        => 6,
                'is_active'     => true,
            ],
            [
                'nama'          => 'Letter Sign Stainless',
                'harga_min'     => 550000,
                'harga_max'     => 1200000,
                'harga_default' => 550000,
                'deskripsi'     => 'Huruf dan logo berbahan stainless steel mirror atau hairline. Tahan karat dan sangat tahan lama. Cocok untuk fasad gedung dan lobby.',
                'urutan'        => 7,
                'is_active'     => true,
            ],
            [
                'nama'          => 'Neon Sign Kawat (Wire Neon)',
                'harga_min'     => 600000,
                'harga_max'     => 1500000,
                'harga_default' => 600000,
                'deskripsi'     => 'Neon sign menggunakan LED flex wire berbentuk custom tulisan atau logo. Tren terkini untuk dekorasi kafe, studio foto, dan retail modern.',
                'urutan'        => 8,
                'is_active'     => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
