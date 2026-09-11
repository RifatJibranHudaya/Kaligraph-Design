<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['order', 'user'])->latest('id');

        // Filter by order_id if provided
        if ($request->filled('order_id')) {
            $query->where('order_id', $request->order_id);
        }

        // Filter by metode
        if ($request->filled('metode')) {
            $query->where('metode', $request->metode);
        }

        $payments = $query->paginate(20);
        $orders = Order::latest('id')->get(['id', 'nama_pelanggan', 'total']);

        return view('pembayaran.index', compact('payments', 'orders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id'      => 'required|exists:orders,id',
            'jumlah'        => 'required|numeric|min:1',
            'metode'        => 'required|string|in:cash,transfer,dp',
            'bukti'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'keterangan'    => 'nullable|string',
            'tanggal_bayar' => 'required|date',
        ], [
            'order_id.required'      => 'Pilih order terkait.',
            'jumlah.required'        => 'Jumlah pembayaran wajib diisi.',
            'tanggal_bayar.required' => 'Tanggal bayar wajib diisi.',
            'bukti.image'            => 'File bukti harus berupa gambar.',
            'bukti.max'              => 'Ukuran bukti maksimal 3 MB.',
        ]);

        $validated['user_id'] = Auth::id();

        if ($request->hasFile('bukti')) {
            $file = $request->file('bukti');
            $filename = 'pay_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/payments'), $filename);
            $validated['bukti'] = $filename;
        }

        $payment = Payment::create($validated);
        $order = Order::find($validated['order_id']);

        ActivityLogService::log(
            'create_payment',
            'pembayaran',
            "Pembayaran Rp " . number_format($validated['jumlah'], 0, ',', '.') . " untuk Order #{$order->id} ({$order->nama_pelanggan})",
            $payment->id
        );

        return back()->with('success', "Pembayaran berhasil dicatat.");
    }

    public function destroy(Payment $payment)
    {
        $orderId = $payment->order_id;
        $jumlah = $payment->jumlah;

        if ($payment->bukti && File::exists(public_path('uploads/payments/' . $payment->bukti))) {
            File::delete(public_path('uploads/payments/' . $payment->bukti));
        }

        $payment->delete();

        ActivityLogService::log(
            'delete_payment',
            'pembayaran',
            "Pembayaran Rp " . number_format($jumlah, 0, ',', '.') . " untuk Order #{$orderId} dihapus",
            $orderId
        );

        return back()->with('success', "Data pembayaran berhasil dihapus.");
    }

    /**
     * Display printable payment receipt / invoice nota.
     */
    public function nota(Payment $payment)
    {
        $payment->load(['order.branch', 'order.user', 'order.payments', 'user']);
        $order = $payment->order;

        $allPayments = $order ? $order->payments()->orderBy('id')->get() : collect([$payment]);
        $totalPaid = $order ? $order->total_dibayar : $payment->jumlah;
        $orderTotal = $order ? (int) $order->total : (int) $payment->jumlah;
        $sisaTagihan = max(0, $orderTotal - $totalPaid);
        $isLunas = $sisaTagihan <= 0;

        return view('pembayaran.nota', compact(
            'payment',
            'order',
            'allPayments',
            'totalPaid',
            'orderTotal',
            'sisaTagihan',
            'isLunas'
        ));
    }
}
