<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StockService
{
    /**
     * Deduct stock for given items during checkout.
     * Must be called inside a DB::transaction with lockForUpdate.
     *
     * @param array $items Array of ['product_id' => int, 'quantity' => int]
     * @throws \Exception If any product has insufficient stock
     */
    public static function deductStock(array $items): void
    {
        foreach ($items as $item) {
            $product = Product::lockForUpdate()->find($item['product_id']);

            if (!$product) {
                throw new \Exception("Produk dengan ID {$item['product_id']} tidak ditemukan.");
            }

            if (!$product->is_active) {
                throw new \Exception("Produk '{$product->nama}' sudah tidak aktif/tersedia.");
            }

            if ($product->stock < $item['quantity']) {
                throw new \Exception(
                    "Stok produk '{$product->nama}' tidak mencukupi. " .
                    "Tersedia: {$product->stock}, diminta: {$item['quantity']}."
                );
            }

            $product->decrement('stock', $item['quantity']);

            Log::info("[Stock] Deducted {$item['quantity']} from product #{$product->id} '{$product->nama}'. Remaining: {$product->stock}");
        }
    }

    /**
     * Return stock when an order is cancelled.
     * Must be called inside a DB::transaction.
     *
     * @param \App\Models\Order $order
     */
    public static function returnStock(\App\Models\Order $order): void
    {
        foreach ($order->items as $item) {
            if ($item->product_id) {
                $product = Product::lockForUpdate()->find($item->product_id);
                if ($product) {
                    $product->increment('stock', $item->quantity);
                    Log::info("[Stock] Returned {$item->quantity} to product #{$product->id} '{$product->nama}'. New stock: {$product->stock}");
                }
            }
        }
    }

    /**
     * Check if all items have sufficient stock without deducting.
     *
     * @param array $items Array of ['product_id' => int, 'quantity' => int]
     * @return array Array of error messages, empty if all OK
     */
    public static function validateStock(array $items): array
    {
        $errors = [];

        foreach ($items as $item) {
            $product = Product::find($item['product_id']);

            if (!$product) {
                $errors[] = "Produk dengan ID {$item['product_id']} tidak ditemukan.";
                continue;
            }

            if (!$product->is_active) {
                $errors[] = "Produk '{$product->nama}' sudah tidak aktif.";
                continue;
            }

            if ($product->stock < $item['quantity']) {
                $errors[] = "Stok '{$product->nama}' tidak cukup (tersedia: {$product->stock}, diminta: {$item['quantity']}).";
            }
        }

        return $errors;
    }
}
