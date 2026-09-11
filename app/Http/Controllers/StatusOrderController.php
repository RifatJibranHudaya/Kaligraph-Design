<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;

class StatusOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'branch', 'items', 'payments'])->latest('id');

        // Filter by status tab
        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        // Search by customer name or order id
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pelanggan', 'like', "%{$search}%")
                  ->orWhere('id', $search)
                  ->orWhere('no_hp', 'like', "%{$search}%");
            });
        }

        $orders = $query->paginate(15);

        // Counts per status for tab badges
        $statusCounts = [
            'semua'       => Order::count(),
            'order'       => Order::where('status', 'order')->count(),
            'on_progress' => Order::where('status', 'on_progress')->count(),
            'selesai'     => Order::where('status', 'selesai')->count(),
            'cancelled'   => Order::where('status', 'cancelled')->count(),
        ];

        // Fetch categories for option values in new order modal
        $categories = Category::active()->ordered()->get();

        return view('status-order.index', compact('orders', 'statusCounts', 'categories'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:order,on_progress,selesai,cancelled',
        ]);

        $oldStatus = $order->status_label;
        $order->status = $validated['status'];
        $order->save();

        $newStatus = $order->status_label;

        ActivityLogService::log(
            'update_order_status',
            'status_order',
            "Status Order #{$order->id} diubah dari '{$oldStatus}' menjadi '{$newStatus}'",
            $order->id
        );

        return back()->with('success', "Status Order #{$order->id} berhasil diubah menjadi '{$newStatus}'.");
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pelanggan' => 'required|string|max:150',
            'no_hp'          => 'nullable|string|max:20',
            'alamat'         => 'nullable|string',
            'kategori'       => 'nullable|string|max:100',
            'total'          => 'required|numeric|min:0',
            'keterangan'     => 'nullable|string',
        ], [
            'nama_pelanggan.required' => 'Nama pelanggan wajib diisi.',
            'total.required'          => 'Total harga wajib diisi.',
        ]);

        $validated['status'] = 'order';
        $validated['user_id'] = auth()->id();

        $order = Order::create($validated);

        ActivityLogService::log(
            'create_order',
            'status_order',
            "Order #{$order->id} dibuat untuk '{$order->nama_pelanggan}' (Total: Rp " . number_format($order->total, 0, ',', '.') . ")",
            $order->id
        );

        return back()->with('success', "Order #{$order->id} berhasil dibuat.");
    }

    /**
     * AJAX Autocomplete search for customers from registered customer users & past orders.
     */
    public function searchPelanggan(Request $request)
    {
        $q = trim($request->get('q', ''));
        if (empty($q)) {
            return response()->json([]);
        }

        // Search in registered customers
        $customers = User::where(function ($query) {
                $query->where('user_type', 'customer')
                      ->orWhere('level', 'customer');
            })
            ->where(function ($query) use ($q) {
                $query->where('username', 'LIKE', "%{$q}%")
                      ->orWhere('email', 'LIKE', "%{$q}%")
                      ->orWhere('phone', 'LIKE', "%{$q}%");
            })
            ->limit(10)
            ->get(['id', 'username', 'email', 'phone']);

        $customerNames = $customers->pluck('username')->toArray();

        // Search distinct from past orders if space allows
        $pastOrders = collect();
        if ($customers->count() < 10) {
            $pastOrders = Order::whereNotNull('nama_pelanggan')
                ->where('nama_pelanggan', '!=', '')
                ->where('nama_pelanggan', 'LIKE', "%{$q}%")
                ->whereNotIn('nama_pelanggan', $customerNames)
                ->select('nama_pelanggan', 'no_hp', 'alamat')
                ->distinct()
                ->limit(10 - $customers->count())
                ->get();
        }

        $results = [];

        foreach ($customers as $c) {
            $results[] = [
                'type'   => 'Pelanggan Terdaftar',
                'nama'   => $c->username,
                'no_hp'  => $c->phone ?? '',
                'email'  => $c->email ?? '',
                'alamat' => '',
            ];
        }

        foreach ($pastOrders as $po) {
            $results[] = [
                'type'   => 'Riwayat Pesanan',
                'nama'   => $po->nama_pelanggan,
                'no_hp'  => $po->no_hp ?? '',
                'email'  => '',
                'alamat' => $po->alamat ?? '',
            ];
        }

        return response()->json($results);
    }
}
