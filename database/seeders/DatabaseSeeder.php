<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\HomeContent;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Default Branch
        $branchUtama = Branch::firstOrCreate(
            ['nama_cabang' => 'Showroom Utama - Pusat'],
            ['alamat' => 'Jl. Raya Signage No. 1, Jakarta Selatan', 'map_url' => null]
        );

        Branch::firstOrCreate(
            ['nama_cabang' => 'Workshop Kaligraph - Cabang Barat'],
            ['alamat' => 'Jl. HR Muhammad No. 45, Surabaya Barat', 'map_url' => null]
        );

        // 2. Create Initial Accounts
        $superadmin = User::firstOrCreate(
            ['username' => 'admin'],
            [
                'email'     => 'admin@kaligraphdesign.com',
                'phone'     => '081234567890',
                'password'  => Hash::make('admin'),
                'level'     => 'superadmin',
                'branch_id' => $branchUtama->id,
            ]
        );

        $owner = User::firstOrCreate(
            ['username' => 'owner'],
            [
                'email'     => 'owner@kaligraphdesign.com',
                'phone'     => '081234567891',
                'password'  => Hash::make('owner'),
                'level'     => 'owner',
                'branch_id' => $branchUtama->id,
            ]
        );

        $kasir = User::firstOrCreate(
            ['username' => 'kasir'],
            [
                'email'     => 'kasir@kaligraphdesign.com',
                'phone'     => '081234567892',
                'password'  => Hash::make('kasir'),
                'level'     => 'kasir',
                'branch_id' => $branchUtama->id,
            ]
        );

        // 3. Create Sample Categories & Products
        $this->call(CategoryAndProductSeeder::class);
        $this->call(PortfolioSeeder::class);

        // 4. Create Initial Home Content
        HomeContent::firstOrCreate(
            ['section' => 'hero'],
            [
                'title'       => 'Solusi Neon Box Custom Terbaik',
                'subtitle'    => 'Spesialis Neon Box & Signage Custom',
                'content'     => 'Kaligraph Design menghadirkan neon box akrilik, flexy, LED, huruf timbul, dan signage custom berkualitas premium. Garansi terpasang, harga bersaing, layanan seluruh Indonesia.',
                'icon'        => '💡',
                'order_index' => 1,
                'is_active'   => true,
            ]
        );

        HomeContent::firstOrCreate(
            ['section' => 'about'],
            [
                'title'       => 'Tentang Kaligraph Design',
                'subtitle'    => 'Pengalaman 8+ Tahun di Industri Signage',
                'content'     => 'Kami berkomitmen menghadirkan solusi neon box dan signage berkualitas tinggi dengan material premium, pengerjaan presisi, dan layanan purna jual terpercaya.',
                'icon'        => '🏪',
                'order_index' => 2,
                'is_active'   => true,
            ]
        );
    }
}
