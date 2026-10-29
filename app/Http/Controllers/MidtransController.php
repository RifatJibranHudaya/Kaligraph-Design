<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Services\MidtransService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    /**
     * Display the dedicated Midtrans online payment page for an e-commerce order.
     */
    public function showPaymentPage(Order $order)
    {
        $authUser = Auth::guard('customer')->user() ?: Auth::guard('web')->user();
        if (!$authUser) {
            return redirect()->route('login.customer')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Customer can only access their own order
        if ($authUser->isCustomer() && $order->user_id !== $authUser->id) {
            return redirect()->route('customer.dashboard')->with('error', 'Anda tidak memiliki akses ke pesanan ini.');
        }

        // Restrict Midtrans only to e-commerce products
        if (!$order->isEcommerce()) {
            return redirect()->route('customer.order.detail', $order->id)
                ->with('error', 'Pembayaran via Midtrans hanya tersedia untuk produk e-commerce.');
        }

        $order->load(['items.product.category', 'payments.user', 'branch']);

        $sisaTagihan = max(0, (int) $order->sisa_tagihan);
        $totalPaid = (int) $order->total_dibayar;
        $orderTotal = (int) $order->total;
        $isLunas = $sisaTagihan <= 0;

        // Ensure snap token is created if configured and order is not yet paid
        $snapToken = $order->snap_token;
        if (!$isLunas && empty($snapToken) && MidtransService::isConfigured()) {
            try {
                $midtransService = new MidtransService();
                $snapToken = $midtransService->createSnapToken($order, $sisaTagihan);
            } catch (\Throwable $e) {
                Log::warning("Could not auto-generate Snap token for Order #{$order->id}: " . $e->getMessage());
            }
        }

        return view('customer.midtrans-payment', compact(
            'order',
            'orderTotal',
            'totalPaid',
            'sisaTagihan',
            'isLunas',
            'snapToken'
        ));
    }

    /**
     * Client-side Snap payment success confirmation endpoint.
     */
    public function paymentSuccessCallback(Request $request, Order $order): JsonResponse
    {
        $authUser = Auth::guard('customer')->user() ?: Auth::guard('web')->user();
        if (!$authUser) {
            return response()->json(['status' => 'error', 'message' => 'Silakan login terlebih dahulu.'], 401);
        }

        if ($authUser->isCustomer() && $order->user_id !== $authUser->id) {
            return response()->json(['status' => 'error', 'message' => 'Akses ditolak.'], 403);
        }

        $result = $request->input('result', []);
        $transactionId = $result['transaction_id'] ?? ('SNAP-' . time());
        $paymentType = $result['payment_type'] ?? 'midtrans';
        $grossAmount = (int) round((float) ($result['gross_amount'] ?? $order->sisa_tagihan));

        DB::transaction(function () use ($order, $grossAmount, $paymentType, $transactionId) {
            $order = Order::lockForUpdate()->findOrFail($order->id);

            // Deduct stock if not yet deducted
            if (!$order->stock_deducted) {
                $order->loadMissing('items.product');
                foreach ($order->items as $item) {
                    if ($item->product_id) {
                        $p = Product::lockForUpdate()->find($item->product_id);
                        if ($p) {
                            $p->decrement('stock', min($p->stock, $item->quantity));
                        }
                    }
                }
                $order->stock_deducted = true;
            }

            // Create payment record if not yet created
            $exists = Payment::where('order_id', $order->id)
                ->where('keterangan', 'like', "%{$transactionId}%")
                ->exists();

            if (!$exists) {
                Payment::create([
                    'order_id'      => $order->id,
                    'user_id'       => $order->user_id,
                    'jumlah'        => $grossAmount > 0 ? $grossAmount : $order->sisa_tagihan,
                    'metode'        => substr('midtrans_' . $paymentType, 0, 30),
                    'bukti'         => null,
                    'keterangan'    => 'Pembayaran Midtrans (' . $transactionId . ')',
                    'tanggal_bayar' => now(),
                ]);
            }

            $order->payment_status = 'verified';
            $order->payment_verified_at = now();
            $order->save();
        });

        return response()->json([
            'status'  => 'success',
            'message' => 'Pembayaran berhasil dikonfirmasi dan diverifikasi.',
        ]);
    }

    /**
     * Get or generate a Midtrans Snap Token for customer payment.
     */
    public function getSnapToken(Order $order): JsonResponse
    {
        $authUser = Auth::guard('customer')->user() ?: Auth::guard('web')->user();
        if (!$authUser) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Silakan login terlebih dahulu.',
            ], 401);
        }

        // Customer can only access their own order, admin/staff can access any order
        if ($authUser->isCustomer() && $order->user_id !== $authUser->id) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Anda tidak memiliki akses ke pesanan ini.',
            ], 403);
        }

        // Restrict Midtrans only to e-commerce products
        if (!$order->isEcommerce()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Pembayaran via Midtrans hanya tersedia untuk produk e-commerce.',
            ], 403);
        }

        if (!MidtransService::isConfigured()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Payment Gateway Midtrans belum dikonfigurasi oleh pengelola.',
            ], 503);
        }

        $sisaTagihan = max(0, (int) $order->sisa_tagihan);
        if ($sisaTagihan <= 0) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Pesanan ini sudah lunas.',
            ], 400);
        }

        try {
            $midtransService = new MidtransService();
            $snapToken = $midtransService->createSnapToken($order, $sisaTagihan);

            return response()->json([
                'status'     => 'success',
                'snap_token' => $snapToken,
                'snap_url'   => MidtransService::getSnapUrl(),
                'client_key' => config('services.midtrans.client_key'),
            ]);
        } catch (\Throwable $e) {
            Log::error('Error fetching Snap Token: ' . $e->getMessage(), [
                'order_id' => $order->id,
            ]);

            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal membuat tagihan pembayaran Midtrans: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Webhook notification endpoint called by Midtrans.
     */
    public function webhook(Request $request): JsonResponse
    {
        if ($request->isMethod('get')) {
            return response()->json([
                'status'  => 'ok',
                'message' => 'Midtrans Webhook endpoint is active and ready to receive POST notifications.',
                'configured' => MidtransService::isConfigured(),
            ], 200);
        }

        $payload = $request->all();
        Log::info('Midtrans Webhook Received', $payload);

        // Handle Midtrans portal test ping / handshake
        if (
            (isset($payload['status_code']) && $payload['status_code'] == '200' && !isset($payload['signature_key'])) ||
            (isset($payload['order_id']) && (str_starts_with($payload['order_id'], 'payment_notif_test') || str_contains($payload['order_id'], 'test_')))
        ) {
            return response()->json(['status' => 'ok', 'message' => 'Midtrans ping/test acknowledged'], 200);
        }

        try {
            $midtransService = new MidtransService();
            $result = $midtransService->handleNotification($payload);

            return response()->json($result, $result['status'] === 'error' ? 400 : 200);
        } catch (\Throwable $e) {
            Log::error('Midtrans Webhook Exception: ' . $e->getMessage(), $payload);

            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
