<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * Display customer portal dashboard (orders, products catalog, and profile).
     */
    public function index()
    {
        $user = Auth::guard('customer')->user() ?: Auth::guard('web')->user();
        
        // Fetch customer's orders
        $orders = Order::where('user_id', $user->id)
            ->with(['branch', 'items.product'])
            ->latest()
            ->paginate(10);

        // Fetch products catalog
        $products = Product::where('is_active', true)
            ->orderBy('urutan')
            ->get();

        $branches = Branch::all();

        return view('customer.dashboard', compact('user', 'orders', 'products', 'branches'));
    }
}
