<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\ActivityLogService;
use App\Services\CartService;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        // Verify product is active and ecommerce before adding
        $product = Product::active()->find($validated['product_id']);
        if (!$product || !$product->isEcommerce()) {
            return back()->with('error', 'Produk ini hanya dapat dipesan melalui konsultasi WhatsApp.');
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

    /**
     * Instant Buy / Direct Checkout with Midtrans for an E-Commerce Product.
     */
    public function instantBuy(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => 'nullable|integer|min:1|max:999',
        ]);
        $quantity = $validated['quantity'] ?? 1;

        $user = Auth::guard('customer')->user();
        if (!$user) {
            return response()->json([
                'status'    => 'unauthenticated',
                'login_url' => route('login.customer', ['redirect' => url()->previous()]),
                'message'   => 'Silakan login akun pelanggan terlebih dahulu untuk melanjutkan pembayaran.',
            ], 401);
        }

        if (!$product->is_active || !$product->isEcommerce()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Produk ini tidak tersedia untuk pembelian langsung.',
            ], 400);
        }

        if ($product->stock < $quantity) {
            return response()->json([
                'status'  => 'error',
                'message' => "Stok produk tidak mencukupi (tersedia: {$product->stock}).",
            ], 400);
        }

        try {
            $unitPrice = (int) $product->harga_default;
            $serverTotal = $unitPrice * $quantity;

            $order = DB::transaction(function () use ($user, $product, $quantity, $unitPrice, $serverTotal) {
                $p = Product::lockForUpdate()->findOrFail($product->id);
                if ($p->stock < $quantity) {
                    throw new \Exception("Stok tidak mencukupi (tersedia: {$p->stock}).");
                }
                // NOTE: Stock is NOT decremented here to prevent depletion if customer cancels/exits before paying.
                // Stock is deducted atomically upon successful Midtrans payment confirmation.

                $newOrder = Order::create([
                    'user_id'         => $user->id,
                    'branch_id'       => null,
                    'kategori'        => $product->category->nama ?? null,
                    'total'           => $serverTotal,
                    'status'          => Order::STATUS_ORDER,
                    'payment_status'  => 'pending',
                    'stock_deducted'  => false,
                    'nama_pelanggan'  => $user->username,
                    'no_hp'           => $user->phone ?? '',
                    'alamat'          => '',
                    'keterangan'      => 'Beli Langsung: ' . $product->nama . ' (x' . $quantity . ')',
                ]);

                OrderItem::create([
                    'order_id'   => $newOrder->id,
                    'product_id' => $product->id,
                    'produk'     => $product->nama,
                    'harga'      => $serverTotal,
                    'quantity'   => $quantity,
                    'unit_price' => $unitPrice,
                ]);

                return $newOrder;
            });

            ActivityLogService::log(
                'instant_buy',
                'order',
                "Instant Buy Order #{$order->id} for {$product->nama} (x{$quantity}) - Rp " . number_format($serverTotal, 0, ',', '.'),
                $order->id
            );

            // Generate Snap Token
            $midtransService = new MidtransService();
            $snapToken = $midtransService->createSnapToken($order, $serverTotal);

            return response()->json([
                'status'       => 'success',
                'order_id'     => $order->id,
                'snap_token'   => $snapToken,
                'redirect_url' => route('customer.order.midtrans', $order->id),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal memproses pesanan: ' . $e->getMessage(),
            ], 500);
        }
    }
}
