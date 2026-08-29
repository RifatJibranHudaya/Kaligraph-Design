<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class KasirController extends Controller
{
    public function index()
    {
        $products = Product::active()->ordered()->get();
        return view('kasir.index', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori'   => 'required|string',
            'keterangan' => 'nullable|string',
            'items'      => 'required|array|min:1',
            'items.*.nama'  => 'required|string',
            'items.*.harga' => 'required|numeric|min:0',
            'items.*.qty'   => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $branchId = Session::get('active_branch_id', $user->branch_id);

        DB::beginTransaction();
        try {
            $total = 0;
            foreach ($validated['items'] as $item) {
                $total += $item['harga'] * $item['qty'];
            }

            $order = Order::create([
                'user_id'    => $user->id,
                'branch_id'  => $branchId,
                'kategori'   => $validated['kategori'],
                'total'      => $total,
                'keterangan' => $validated['keterangan'] ?? null,
            ]);

            foreach ($validated['items'] as $item) {
                for ($i = 0; $i < $item['qty']; $i++) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'produk'   => $item['nama'],
                        'harga'    => $item['harga'],
                    ]);
                }
            }

            DB::commit();

            ActivityLogService::log(
                'create_order',
                'kasir',
                "Order #{$order->id} dimasukkan oleh {$user->username} (Total: Rp " . number_format($total, 0, ',', '.') . ")",
                $order->id
            );

            if ($request->wantsJson()) {
                return response()->json([
                    'success'  => true,
                    'message'  => 'Transaksi berhasil disimpan!',
                    'order_id' => $order->id,
                ]);
            }

            return redirect()->route('kasir.receipt', $order->id)->with('success', 'Transaksi berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Gagal menyimpan transaksi: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }

    public function receipt(Order $order)
    {
        $order->load(['items', 'user', 'branch']);
        return view('kasir.receipt', compact('order'));
    }

    public function history()
    {
        $user = Auth::user();
        $branchId = Session::get('active_branch_id', $user->branch_id);

        $orders = Order::with(['items', 'user', 'branch'])
            ->when($branchId, fn($q) => $q->where('branch_id', $branchId))
            ->latest('id')
            ->paginate(15);

        return view('kasir.history', compact('orders'));
    }
}
