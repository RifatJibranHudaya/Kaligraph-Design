<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    /**
     * Display customer portal dashboard (orders, products catalog, and profile).
     */
    public function index(Request $request)
    {
        $user = Auth::guard('customer')->user();
        
        if (!$user) {
            return redirect()->route('login.customer');
        }
        
        // Fetch customer's orders - only orders belonging to this authenticated customer
        $orders = Order::where('user_id', $user->id)
            ->with(['branch', 'items.product'])
            ->latest()
            ->paginate(10);

        // Fetch categories for option value select dropdown
        $categories = Category::where('is_active', true)->orderBy('nama')->get();

        // Query products with category relation
        $productQuery = Product::where('is_active', true)->with('category');

        // Filter by category slug/id if provided
        if ($request->filled('kategori') && $request->kategori !== 'semua') {
            $catSlug = $request->kategori;
            $productQuery->whereHas('category', function ($q) use ($catSlug) {
                $q->where('slug', $catSlug)->orWhere('id', $catSlug);
            });
        }

        // Filter by sub-module type (ecommerce or custom_wa) if provided
        if ($request->filled('tipe')) {
            if ($request->tipe === 'ecommerce') {
                $productQuery->ecommerce();
            } elseif ($request->tipe === 'custom_wa') {
                $productQuery->customWa();
            }
        }

        // Sorting
        $sort = $request->get('sort', 'default');
        switch ($sort) {
            case 'price-asc':
                $productQuery->orderBy('harga_min', 'asc');
                break;
            case 'price-desc':
                $productQuery->orderBy('harga_min', 'desc');
                break;
            case 'name-asc':
                $productQuery->orderBy('nama', 'asc');
                break;
            case 'name-desc':
                $productQuery->orderBy('nama', 'desc');
                break;
            default:
                $productQuery->orderBy('urutan');
                break;
        }

        $products = $productQuery->get();
        $branches = Branch::all();

        return view('customer.dashboard', compact('user', 'orders', 'products', 'categories', 'branches'));
    }

    /**
     * Cancel an unpaid order by customer.
     */
    public function cancelOrder(Order $order)
    {
        $user = Auth::guard('customer')->user();
        if (!$user || $order->user_id !== $user->id) {
            return redirect()->route('customer.dashboard')->with('error', 'Akses ditolak.');
        }

        if ($order->payment_status === 'verified' || $order->status === Order::STATUS_SELESAI) {
            return back()->with('error', 'Pesanan yang sudah dibayar atau selesai tidak dapat dibatalkan.');
        }

        OrderService::updateStatus($order, Order::STATUS_CANCELLED);

        return redirect()->route('customer.dashboard')->with('success', "Pesanan #{$order->id} berhasil dibatalkan.");
    }

    /**
     * Update customer profile (username, email, phone).
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::guard('customer')->user();
        
        if (!$user) {
            return redirect()->route('login.customer');
        }

        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $user->update([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? $user->phone,
        ]);

        return redirect()->route('customer.dashboard')->with('success', '✅ Profil berhasil diperbarui!');
    }
}
