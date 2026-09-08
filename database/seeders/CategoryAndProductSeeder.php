<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoryAndProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'nama' => 'Neon Box Akrilik & LED',
                'slug' => 'neon-box-akrilik-led',
                'deskripsi' => 'Solusi neon box modern berbahan akrilik berkualitas tinggi dengan pencahayaan modul LED super terang dan hemat daya.',
                'emoji' => '💡',
                'urutan' => 1,
                'is_active' => true,
                'products' => [
                    [
                        'nama' => 'Neon Box Akrilik Bulat / Round',
                        'harga_min' => 450000,
                        'harga_max' => 900000,
                        'harga_default' => 450000,
                        'deskripsi' => 'Neon box bulat diameter 40-80cm dengan frame aluminium profile, visual akrilik 3mm cutting sticker/flatbed printing, pencahayaan LED modul waterproof.',
                        'urutan' => 1,
                    ],
                    [
                        'nama' => 'Neon Box Akrilik Kotak / Persegi',
                        'harga_min' => 350000,
                        'harga_max' => 750000,
                        'harga_default' => 350000,
                        'deskripsi' => 'Neon box standar persegi berbagai ukuran custom. Frame galvanis anti-karat / aluminium, cover akrilik susu dengan stiker oracal transparan.',
                        'urutan' => 2,
                    ],
                    [
                        'nama' => 'Neon Box Slim / Frame Tipis',
                        'harga_min' => 400000,
                        'harga_max' => 850000,
                        'harga_default' => 400000,
                        'deskripsi' => 'Neon box tipis ultra-slim modern untuk interior toko, mall, atau menu board restoran fast food. Elegan & hemat tempat.',
                        'urutan' => 3,
                    ],
                ],
            ],
            [
                'nama' => 'Huruf Timbul (Channel Letter)',
                'slug' => 'huruf-timbul',
                'deskripsi' => 'Huruf 3D timbul berbahan stainless steel, akrilik, galvanis, atau kuningan dengan pencahayaan LED menyala depan (frontlit) atau belakang (backlit/halo).',
                'emoji' => '🔤',
                'urutan' => 2,
                'is_active' => true,
                'products' => [
                    [
                        'nama' => 'Huruf Timbul Stainless Mirror / Hairline',
                        'harga_min' => 12000,
                        'harga_max' => 25000,
                        'harga_default' => 12000,
                        'deskripsi' => 'Huruf timbul stainless steel plat 0.8mm - 1.2mm anti karat, finishing mirror (mengkilap) atau hairline (doff). Dihitung per cm tinggi huruf.',
                        'urutan' => 1,
                    ],
                    [
                        'nama' => 'Huruf Timbul Akrilik LED Nyala Depan',
                        'harga_min' => 15000,
                        'harga_max' => 30000,
                        'harga_default' => 15000,
                        'deskripsi' => 'Huruf timbul akrilik 3mm dengan pencahayaan modul LED di dalam huruf. Cahaya terang merata, sangat menarik di malam hari.',
                        'urutan' => 2,
                    ],
                    [
                        'nama' => 'Huruf Timbul Backlit Halo Light',
                        'harga_min' => 18000,
                        'harga_max' => 35000,
                        'harga_default' => 18000,
                        'deskripsi' => 'Kombinasi bodi logam stainless dengan efek pendaran cahaya LED dari belakang huruf memantul ke dinding (halo effect). Mewah & eksklusif.',
                        'urutan' => 3,
                    ],
                ],
            ],
            [
                'nama' => 'Neon Flex & Wire Sign',
                'slug' => 'neon-flex-wire-sign',
                'deskripsi' => 'Lampu tulisan atau logo artistik fleksibel berbasis LED flex silicon. Cocok untuk kafe, kamar tidur, photobooth, bar, dan backdrop estetis.',
                'emoji' => '⚡',
                'urutan' => 3,
                'is_active' => true,
                'products' => [
                    [
                        'nama' => 'Custom Neon Flex Quote / Tulisan Estetik',
                        'harga_min' => 250000,
                        'harga_max' => 600000,
                        'harga_default' => 250000,
                        'deskripsi' => 'Custom font tulisan aesthetic neon flex 12V dengan alas akrilik bening 4mm + adaptor + dimmer controller. Bebas request kata-kata.',
                        'urutan' => 1,
                    ],
                    [
                        'nama' => 'Neon Flex Logo Cafe & Coffee Shop',
                        'harga_min' => 450000,
                        'harga_max' => 1200000,
                        'harga_default' => 450000,
                        'deskripsi' => 'Neon flex desain logo kafe, restoran, studio gym, atau barbershop dengan perpaduan warna neon kontras dan tahan lama.',
                        'urutan' => 2,
                    ],
                ],
            ],
            [
                'nama' => 'Bengkel Las & Konstruksi',
                'slug' => 'bengkel-las-konstruksi',
                'deskripsi' => 'Layanan pengerjaan las besi, kanopi galvalum/kaca tempered, pagar minimalis, tralis jendela, rolling door, dan railing tangga.',
                'emoji' => '🛠️',
                'urutan' => 4,
                'is_active' => true,
                'products' => [
                    [
                        'nama' => 'Kanopi Besi Hollow & Atap Alderon / Galvalum',
                        'harga_min' => 350000,
                        'harga_max' => 650000,
                        'harga_default' => 350000,
                        'deskripsi' => 'Pemasangan kanopi carport rangka besi hollow galvanis finishing cat semprot anti karat, atap uPVC alderon dingin & peredam suara hujan.',
                        'urutan' => 1,
                    ],
                    [
                        'nama' => 'Pagar Minimalis Modern & Woodplank',
                        'harga_min' => 400000,
                        'harga_max' => 750000,
                        'harga_default' => 400000,
                        'deskripsi' => 'Pagar rumah minimalis perpaduan besi hollow galvanis dan papan woodplank motif kayu tahan cuaca & rayap.',
                        'urutan' => 2,
                    ],
                    [
                        'nama' => 'Tralis Jendela & Pintu Pengaman Besi',
                        'harga_min' => 200000,
                        'harga_max' => 450000,
                        'harga_default' => 200000,
                        'deskripsi' => 'Tralis pengaman jendela besi nako / square hollow motif minimalis kokoh dan presisi.',
                        'urutan' => 3,
                    ],
                ],
            ],
            [
                'nama' => 'Pylon Sign & Totem Gedung',
                'slug' => 'pylon-sign-totem',
                'deskripsi' => 'Papan petunjuk & signage berdiri vertikal (freestanding) untuk pom bensin SPBU, gedung perkantoran, perbankan, dealer mobil, dan ruko.',
                'emoji' => '🏢',
                'urutan' => 5,
                'is_active' => true,
                'products' => [
                    [
                        'nama' => 'Pylon Sign ACP & Neon Box LED Gedung',
                        'harga_min' => 3500000,
                        'harga_max' => 15000000,
                        'harga_default' => 3500000,
                        'deskripsi' => 'Struktur tiang pylon kokoh besi WF/UNP, cladding aluminium composite panel (ACP) seven, dilengkapi lampu neon box akrilik bergaransi.',
                        'urutan' => 1,
                    ],
                ],
            ],
        ];

        foreach ($categories as $catData) {
            $products = $catData['products'] ?? [];
            unset($catData['products']);

            $category = Category::updateOrCreate(
                ['slug' => $catData['slug']],
                $catData
            );

            foreach ($products as $prodData) {
                $prodData['category_id'] = $category->id;
                $prodData['is_active'] = true;
                Product::updateOrCreate(
                    ['nama' => $prodData['nama']],
                    $prodData
                );
            }
        }
    }
}
