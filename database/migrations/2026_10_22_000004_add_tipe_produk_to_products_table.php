<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add tipe_produk to products table:
     * - 'custom_wa': Produk pesanan kustom (spesifikasi khusus, konsultasi/order via WhatsApp)
     * - 'ecommerce': Produk jadi/ready stock (harga fix, kelola stok/SKU, beli langsung via keranjang/checkout ala WooCommerce)
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('tipe_produk', 20)->default('custom_wa')->after('sku');
            $table->index('tipe_produk');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['tipe_produk']);
            $table->dropColumn('tipe_produk');
        });
    }
};
