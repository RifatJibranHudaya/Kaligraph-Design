<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add product_id FK, quantity, unit_price to order_items for proper relational integrity.
     * Backfill existing data by matching product name.
     */
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->nullable()->after('order_id');
            $table->integer('quantity')->default(1)->after('produk');
            $table->decimal('unit_price', 15, 0)->default(0)->after('quantity');

            $table->foreign('product_id')
                  ->references('id')->on('products')
                  ->onDelete('set null');
        });

        // Backfill: match existing 'produk' string to products table
        $items = \DB::table('order_items')->get();
        foreach ($items as $item) {
            $product = \DB::table('products')
                ->where('nama', $item->produk)
                ->first();

            \DB::table('order_items')
                ->where('id', $item->id)
                ->update([
                    'product_id' => $product ? $product->id : null,
                    'unit_price' => $item->harga,
                    'quantity'   => 1,
                ]);
        }
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropColumn(['product_id', 'quantity', 'unit_price']);
        });
    }
};
