<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use App\Services\ActivityLogService;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display the customer's cart.
     */
    public function index()
    {
        $user = Auth::guard('customer')->user();
        $cart = CartService::getOrCreateCart($user);
        $cart->load('items.product.category');

        return view('customer.cart', compact('cart'));
    }

    /**
     * Add a product to cart.
     * Price is always fetched from the server (never trusted from frontend).
     */
    public function addItem(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity'   => 'nullable|integer|min:1|max:999',
        ]);

        $user = Auth::guard('customer')->user();
        $quantity = $validated['quantity'] ?? 1;

        // Verify product is active before adding
        $product = Product::active()->find($validated['product_id']);
        if (!$product) {
            return back()->with('error', 'Produk tidak tersedia.');
        }

        try {
            CartService::addItem($user, $validated['product_id'], $quantity);
            return back()->with('success', "'{$product->nama}' berhasil ditambahkan ke keranjang.");
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update item quantity in cart.
     */
    public function updateItem(Request $request, CartItem $cartItem)
    {
        $user = Auth::guard('customer')->user();
        $cart = CartService::getOrCreateCart($user);

        // Ensure cart item belongs to this user's cart
        if ($cartItem->cart_id !== $cart->id) {
            return back()->with('error', 'Item tidak ditemukan dalam keranjang Anda.');
        }

        $validated = $request->validate([
            'quantity' => 'required|integer|min:0|max:999',
        ]);

        try {
            CartService::updateItem($cartItem, $validated['quantity']);
            
            if ($validated['quantity'] <= 0) {
                return back()->with('success', 'Item berhasil dihapus dari keranjang.');
            }

            return back()->with('success', 'Jumlah item berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove item from cart.
     */
    public function removeItem(CartItem $cartItem)
    {
        $user = Auth::guard('customer')->user();
        $cart = CartService::getOrCreateCart($user);

        // Ensure cart item belongs to this user's cart
        if ($cartItem->cart_id !== $cart->id) {
            return back()->with('error', 'Item tidak ditemukan dalam keranjang Anda.');
        }

        $productName = $cartItem->product->nama ?? 'Item';
        CartService::removeItem($cartItem);

        return back()->with('success', "'{$productName}' berhasil dihapus dari keranjang.");
    }

    /**
     * Checkout: Convert cart to order.
     * All calculations happen server-side. Stock is deducted atomically.
     */
    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'alamat'     => 'nullable|string|max:500',
            'keterangan' => 'nullable|string|max:1000',
        ]);

        $user = Auth::guard('customer')->user();

        try {
            $order = CartService::checkout($user, [
                'alamat'     => $validated['alamat'] ?? '',
                'keterangan' => $validated['keterangan'] ?? null,
            ]);

            ActivityLogService::log(
                'checkout',
                'order',
                "Customer checkout: Order #{$order->id} (Total: Rp " . number_format($order->total, 0, ',', '.') . ")",
                $order->id
            );

            return redirect()->route('customer.order.detail', $order->id)
                ->with('success', "Pesanan #{$order->id} berhasil dibuat! Total: Rp " . number_format($order->total, 0, ',', '.'));

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
