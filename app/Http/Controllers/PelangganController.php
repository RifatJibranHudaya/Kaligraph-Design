<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PelangganController extends Controller
{
    /**
     * Display a listing of registered customers.
     */
    public function index()
    {
        $customers = User::where(function ($q) {
            $q->where('user_type', 'customer')
              ->orWhere('level', 'customer');
        })
        ->withCount('orders')
        ->withSum('orders', 'total')
        ->latest('id')
        ->get();

        return view('pelanggan.index', compact('customers'));
    }

    /**
     * Store a newly created customer in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:50|unique:users,username',
            'email'    => 'required|email|max:100|unique:users,email',
            'phone'    => 'required|string|max:20',
            'password' => 'required|string|min:6',
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.unique'   => 'Username sudah digunakan.',
            'email.required'    => 'Email wajib diisi.',
            'email.unique'      => 'Email sudah terdaftar.',
            'phone.required'    => 'Nomor WhatsApp/HP wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.',
        ]);

        $validated['password']  = Hash::make($validated['password']);
        $validated['level']     = 'customer';
        $validated['user_type'] = 'customer';

        $customer = User::create($validated);

        ActivityLogService::log('create_customer', 'users', "Akun pelanggan '{$customer->username}' ({$customer->email}) ditambahkan oleh admin", $customer->id);

        return back()->with('success', "Pelanggan '{$customer->username}' berhasil ditambahkan.");
    }

    /**
     * Update customer information.
     */
    public function update(Request $request, User $pelanggan)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:50|unique:users,username,' . $pelanggan->id,
            'email'    => 'required|email|max:100|unique:users,email,' . $pelanggan->id,
            'phone'    => 'required|string|max:20',
            'password' => 'nullable|string|min:6',
        ], [
            'username.required' => 'Username wajib diisi.',
            'email.required'    => 'Email wajib diisi.',
            'phone.required'    => 'Nomor telepon wajib diisi.',
            'password.min'      => 'Password baru minimal 6 karakter.',
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $pelanggan->update($validated);

        ActivityLogService::log('update_customer', 'users', "Data pelanggan '{$pelanggan->username}' diperbarui", $pelanggan->id);

        return back()->with('success', "Data pelanggan '{$pelanggan->username}' berhasil diperbarui.");
    }

    /**
     * Remove customer account.
     */
    public function destroy(User $pelanggan)
    {
        $username = $pelanggan->username;
        $id = $pelanggan->id;

        $pelanggan->delete();

        ActivityLogService::log('delete_customer', 'users', "Akun pelanggan '{$username}' dihapus", $id);

        return back()->with('success', "Akun pelanggan '{$username}' berhasil dihapus.");
    }

    /**
     * View specific customer orders.
     */
    public function orders(User $pelanggan)
    {
        $orders = Order::where('user_id', $pelanggan->id)
            ->with(['branch', 'items.product'])
            ->latest('id')
            ->get();

        return view('pelanggan.orders', compact('pelanggan', 'orders'));
    }
}
