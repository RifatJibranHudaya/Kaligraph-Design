<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CartService
{
    /**
     * Get or create a cart for the given user.
     */
    public static function getOrCreateCart(User $user): Cart
    {
        return Cart::firstOrCreate(['user_id' => $user->id]);
    }

    /**
     * Add a product to the user's cart.
     * If the product already exists in cart, increment quantity.
     * Price is always fetched from server (never from frontend).
     */
    public static function addItem(User $user, int $productId, int $quantity = 1): CartItem
    {
        $product = Product::active()->findOrFail($productId);

        if ($product->stock < $quantity) {
            throw new \Exception("Stok '{$product->nama}' tidak mencukupi (tersedia: {$product->stock}).");
        }

        $cart = self::getOrCreateCart($user);

        // Server-side price: use harga_default (= harga_min)
        $unitPrice = (int) $product->harga_default;

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $newQty = $cartItem->quantity + $quantity;
            if ($product->stock < $newQty) {
                throw new \Exception("Stok '{$product->nama}' tidak mencukupi untuk jumlah tersebut (tersedia: {$product->stock}).");
            }
            $cartItem->quantity = $newQty;
            $cartItem->unit_price = $unitPrice; // Always refresh price from DB
            $cartItem->save();
        } else {
            $cartItem = CartItem::create([
                'cart_id'    => $cart->id,
                'product_id' => $productId,
                'quantity'   => $quantity,
                'unit_price' => $unitPrice,
            ]);
        }

        return $cartItem;
    }

    /**
     * Update item quantity in cart.
     * Price is refreshed from server.
     */
    public static function updateItem(CartItem $cartItem, int $quantity): CartItem
    {
        if ($quantity <= 0) {
            $cartItem->delete();
            return $cartItem;
        }

        $product = Product::active()->findOrFail($cartItem->product_id);

        if ($product->stock < $quantity) {
            throw new \Exception("Stok '{$product->nama}' tidak mencukupi (tersedia: {$product->stock}).");
        }

        $cartItem->quantity = $quantity;
        $cartItem->unit_price = (int) $product->harga_default; // Always refresh price
        $cartItem->save();

        return $cartItem;
    }

    /**
     * Remove item from cart.
     */
    public static function removeItem(CartItem $cartItem): void
    {
        $cartItem->delete();
    }

    /**
     * Checkout: Convert cart to order within a single DB transaction.
     * - Validates all products are active + in stock
     * - Calculates total server-side (price × quantity)
     * - Deducts stock with lockForUpdate
     * - Creates order + order_items
     * - Clears the cart
     *
     * @throws \Exception on validation failure
     */
    public static function checkout(User $user, array $extraData = []): Order
    {
        return DB::transaction(function () use ($user, $extraData) {
            $cart = Cart::where('user_id', $user->id)->first();

            if (!$cart || $cart->items()->count() === 0) {
                throw new \Exception('Keranjang belanja kosong.');
            }

            $cart->load('items.product');

            // Prepare items for stock validation & deduction
            $stockItems = [];
            $serverTotal = 0;

            foreach ($cart->items as $cartItem) {
                $product = Product::lockForUpdate()->find($cartItem->product_id);

                if (!$product || !$product->is_active) {
                    throw new \Exception("Produk '{$cartItem->product->nama}' sudah tidak tersedia.");
                }

                if ($product->stock < $cartItem->quantity) {
                    throw new \Exception(
                        "Stok '{$product->nama}' tidak mencukupi (tersedia: {$product->stock}, diminta: {$cartItem->quantity})."
                    );
                }

                // Server-side price calculation — NEVER trust frontend price
                $unitPrice = (int) $product->harga_default;
                $lineTotal = $unitPrice * $cartItem->quantity;
                $serverTotal += $lineTotal;

                $stockItems[] = [
                    'product'    => $product,
                    'quantity'   => $cartItem->quantity,
                    'unit_price' => $unitPrice,
                    'produk'     => $product->nama,
                ];
            }

            // Create Order with server-calculated total
            $order = Order::create([
                'user_id'         => $user->id,
                'branch_id'       => $extraData['branch_id'] ?? null,
                'kategori'        => $extraData['kategori'] ?? null,
                'total'           => $serverTotal,
                'keterangan'      => $extraData['keterangan'] ?? null,
                'status'          => Order::STATUS_ORDER,
                'nama_pelanggan'  => $user->username,
                'no_hp'           => $user->phone ?? '',
                'alamat'          => $extraData['alamat'] ?? '',
            ]);

            // Create Order Items & deduct stock
            foreach ($stockItems as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item['product']->id,
                    'produk'     => $item['produk'],
                    'harga'      => $item['unit_price'] * $item['quantity'],
                    'quantity'   => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                ]);

                // Deduct stock
                $item['product']->decrement('stock', $item['quantity']);
            }

            // Clear cart after successful checkout
            $cart->items()->delete();

            return $order;
        });
    }
}
