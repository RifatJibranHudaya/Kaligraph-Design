<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Support\Str;
use Tests\TestCase;

class DualProductSubmoduleTest extends TestCase
{
    /**
     * Test creating both custom_wa and ecommerce sub-module products.
     */
    public function test_can_create_custom_wa_and_ecommerce_products(): void
    {
        $uid = uniqid();
        $category = Category::create([
            'nama' => 'Category ' . $uid,
            'slug' => 'cat-' . $uid,
            'is_active' => true,
        ]);

        // 1. Create Custom WA Product
        $customProd = ProductService::createProduct([
            'nama' => 'Neon Box Custom Logo Perusahaan ' . $uid,
            'category_id' => $category->id,
            'tipe_produk' => Product::TIPE_CUSTOM_WA,
            'harga_min' => 750000,
            'harga_max' => 2500000,
            'deskripsi' => 'Ukuran dan bentuk bebas sesuai logo.',
            'is_active' => true,
        ]);

        $this->assertEquals(Product::TIPE_CUSTOM_WA, $customProd->tipe_produk);
        $this->assertTrue($customProd->isCustomWa());
        $this->assertFalse($customProd->isEcommerce());
        $this->assertEquals('Pesanan Kustom (WA)', $customProd->tipe_label);
        $this->assertStringContainsString('750.000', $customProd->harga_display);

        // 2. Create E-Commerce Product
        $ecommerceProd = ProductService::createProduct([
            'nama' => 'Trafo LED Waterproof 12V 400W ' . $uid,
            'category_id' => $category->id,
            'tipe_produk' => Product::TIPE_ECOMMERCE,
            'sku' => 'TF-' . strtoupper($uid),
            'stock' => 25,
            'harga_min' => 185000,
            'deskripsi' => 'Power supply trafo siap pakai.',
            'is_active' => true,
        ]);

        $this->assertEquals(Product::TIPE_ECOMMERCE, $ecommerceProd->tipe_produk);
        $this->assertTrue($ecommerceProd->isEcommerce());
        $this->assertFalse($ecommerceProd->isCustomWa());
        $this->assertEquals(25, $ecommerceProd->stock);
        $this->assertEquals('TF-' . strtoupper($uid), $ecommerceProd->sku);
        $this->assertEquals('E-Commerce (Ready Stock)', $ecommerceProd->tipe_label);

        // Clean up
        $customProd->delete();
        $ecommerceProd->delete();
        $category->delete();
    }

    /**
     * Test quick stock adjustment for e-commerce products.
     */
    public function test_quick_stock_adjustment(): void
    {
        $uid = uniqid();
        $product = Product::create([
            'nama' => 'Lampu Neon Flex LED ' . $uid,
            'tipe_produk' => Product::TIPE_ECOMMERCE,
            'sku' => 'NF-' . strtoupper($uid),
            'stock' => 10,
            'harga_default' => 85000,
            'harga_min' => 85000,
            'is_active' => true,
        ]);

        ProductService::adjustStock($product, 40, 'Restock kontainer');

        $product->refresh();
        $this->assertEquals(40, $product->stock);

        $product->delete();
    }

    /**
     * Test Catalog renders both types correctly with proper badge and CTA.
     */
    public function test_catalog_displays_submodule_badges_and_filters(): void
    {
        $uid = uniqid();
        $category = Category::create([
            'nama' => 'Huruf Timbul ' . $uid,
            'slug' => 'ht-' . $uid,
            'is_active' => true,
        ]);

        $pWa = Product::create([
            'category_id' => $category->id,
            'nama' => 'Huruf Timbul Custom ' . $uid,
            'tipe_produk' => Product::TIPE_CUSTOM_WA,
            'harga_default' => 15000,
            'harga_min' => 15000,
            'is_active' => true,
        ]);

        $pEc = Product::create([
            'category_id' => $category->id,
            'nama' => 'Lem Akrilik Khusus ' . $uid,
            'tipe_produk' => Product::TIPE_ECOMMERCE,
            'sku' => 'LEM-' . strtoupper($uid),
            'stock' => 50,
            'harga_default' => 45000,
            'harga_min' => 45000,
            'is_active' => true,
        ]);

        // Visit Category page
        $response = $this->get(route('katalog.kategori', $category->slug));
        $response->assertStatus(200);
        $response->assertSee('Huruf Timbul Custom ' . $uid);
        $response->assertSee('Lem Akrilik Khusus ' . $uid);
        $response->assertSee('Ready Stock');
        $response->assertSee('Custom WA');

        // Test filter ecommerce only
        $resEc = $this->get(route('katalog.kategori', ['slug' => $category->slug, 'tipe' => 'ecommerce']));
        $resEc->assertStatus(200);
        $resEc->assertSee('Lem Akrilik Khusus ' . $uid);
        $resEc->assertDontSee('Huruf Timbul Custom ' . $uid);

        // Test Detail Page of E-Commerce Product shows Add to Cart button
        $resDetailEc = $this->get(route('katalog.detail', [$category->slug, $pEc->id]));
        $resDetailEc->assertStatus(200);
        $resDetailEc->assertSee('Tambah ke Keranjang');
        $resDetailEc->assertSee('Stok Tersedia: 50 pcs');

        // Test Detail Page of Custom WA Product shows WhatsApp Consultation button
        $resDetailWa = $this->get(route('katalog.detail', [$category->slug, $pWa->id]));
        $resDetailWa->assertStatus(200);
        $resDetailWa->assertSee('Konsultasi');
        $resDetailWa->assertSee('Pesan via WhatsApp');

        // Clean up
        $pWa->delete();
        $pEc->delete();
        $category->delete();
    }
}
