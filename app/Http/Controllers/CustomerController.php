<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    /**
     * Display customer portal dashboard (orders, products catalog, and profile).
     */
    public function index()
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

        // Fetch products catalog
        $products = Product::where('is_active', true)
            ->orderBy('urutan')
            ->get();

        $branches = Branch::all();

        return view('customer.dashboard', compact('user', 'orders', 'products', 'branches'));
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
