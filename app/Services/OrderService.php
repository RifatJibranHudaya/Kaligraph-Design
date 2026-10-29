<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class OrderService
{
    /**
     * Create an order from admin panel (with manual items/total).
     * Wraps in DB::transaction, calculates server-side total if items are provided.
     */
    public static function createFromAdmin(array $validated, ?int $userId = null): Order
    {
        return DB::transaction(function () use ($validated, $userId) {
            $validated['status'] = Order::STATUS_ORDER;
            $validated['user_id'] = $userId ?? auth()->id();

            $order = Order::create($validated);

            return $order;
        });
    }

    /**
     * Update order status with stock handling.
     * If cancelling an order, return stock to products.
     */
    public static function updateStatus(Order $order, string $newStatus): Order
    {
        return DB::transaction(function () use ($order, $newStatus) {
            $order = Order::lockForUpdate()->findOrFail($order->id);
            $oldStatus = $order->status;

            // If changing TO cancelled, return stock if it was previously deducted
            if ($newStatus === Order::STATUS_CANCELLED && $oldStatus !== Order::STATUS_CANCELLED) {
                if ($order->stock_deducted) {
                    StockService::returnStock($order);
                    $order->stock_deducted = false;
                }
            }

            // If changing FROM cancelled to active status, re-deduct stock if needed
            if ($oldStatus === Order::STATUS_CANCELLED && $newStatus !== Order::STATUS_CANCELLED) {
                if (!$order->stock_deducted) {
                    $items = $order->items->map(function ($item) {
                        return [
                            'product_id' => $item->product_id,
                            'quantity'   => $item->quantity,
                        ];
                    })->filter(fn($item) => $item['product_id'] !== null)->toArray();

                    if (!empty($items)) {
                        StockService::deductStock($items);
                        $order->stock_deducted = true;
                    }
                }
            }

            $order->status = $newStatus;
            $order->save();

            return $order;
        });
    }
}
