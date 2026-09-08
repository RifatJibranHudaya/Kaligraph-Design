<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Portfolio;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        $cats = Category::all();
        $c1 = $cats->first();
        $c2 = $cats->skip(1)->first();

        Portfolio::updateOrCreate(
            ['nama' => 'Neon Box Acrylic Warung Kopi Nusantara'],
            [
                'category_id' => $c1 ? $c1->id : null,
                'deskripsi'   => 'Pemasangan Neon Box Akrilik 2 Sisi dengan penerangan LED Samsung Super Bright dan rangka hollow galvanis anti karat.',
                'client'      => 'Warung Kopi Nusantara',
                'lokasi'      => 'Demak, Jawa Tengah',
                'tahun'       => '2025',
                'is_active'   => true,
                'urutan'      => 1,
            ]
        );

        Portfolio::updateOrCreate(
            ['nama' => 'Huruf Timbul Stainless Steel Klinik Sehat Medika'],
            [
                'category_id' => $c2 ? $c2->id : null,
                'deskripsi'   => 'Signage huruf timbul stainless 304 dengan backlight LED warm white untuk fasad utama gedung klinik.',
                'client'      => 'Klinik Sehat Medika',
                'lokasi'      => 'Semarang, Jawa Tengah',
                'tahun'       => '2024',
                'is_active'   => true,
                'urutan'      => 2,
            ]
        );

        Portfolio::updateOrCreate(
            ['nama' => 'Neon Box Bulat Double Side Cafe Sunset'],
            [
                'category_id' => $c1 ? $c1->id : null,
                'deskripsi'   => 'Neon box bulat diameter 80cm bahan acrylic cembung dengan cutting sticker oracal dan lampu LED waterproof.',
                'client'      => 'Cafe Sunset Vibes',
                'lokasi'      => 'Kudus, Jawa Tengah',
                'tahun'       => '2025',
                'is_active'   => true,
                'urutan'      => 3,
            ]
        );
    }
}
