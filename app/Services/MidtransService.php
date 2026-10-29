<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    /**
     * Initialize Midtrans configuration from services config.
     */
    public static function initConfig(): void
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = (bool) config('services.midtrans.is_production', false);
        Config::$isSanitized = (bool) config('services.midtrans.is_sanitized', true);
        Config::$is3ds = (bool) config('services.midtrans.is_3ds', true);
    }

    /**
     * Check if Midtrans credentials are configured.
     */
    public static function isConfigured(): bool
    {
        $serverKey = config('services.midtrans.server_key');
        return !empty($serverKey);
    }

    /**
     * Get the Snap JS library URL based on environment.
     */
    public static function getSnapUrl(): string
    {
        return config('services.midtrans.is_production', false)
            ? 'https://app.midtrans.com/snap/snap.js'
            : 'https://app.sandbox.midtrans.com/snap/snap.js';
    }

    /**
     * Generate a Snap token for an order.
     */
    public function createSnapToken(Order $order, ?int $grossAmount = null): string
    {
        self::initConfig();

        $amount = $grossAmount ?: max(0, (int) $order->sisa_tagihan);
        if ($amount <= 0) {
            throw new \Exception('Sisa tagihan pesanan ini sudah Rp 0 (Lunas).');
        }

        $customer = $order->user;
        $orderIdentifier = 'ORDER-' . $order->id . '-' . time();

        $customerName = $customer ? ($customer->name ?? $customer->username ?? 'Pelanggan') : ($order->nama_pelanggan ?? 'Pelanggan');
        $customerEmail = $customer && $customer->email ? $customer->email : 'customer@kaligraphdesign.com';
        $customerPhone = $customer && !empty($customer->phone) ? $customer->phone : ($order->no_hp ?? '08123456789');

        $params = [
            'transaction_details' => [
                'order_id'     => $orderIdentifier,
                'gross_amount' => $amount,
            ],
            'customer_details' => [
                'first_name' => $customerName,
                'email'      => $customerEmail,
                'phone'      => $customerPhone,
            ],
            'item_details' => [
                [
                    'id'       => 'ORDER-' . $order->id,
                    'price'    => $amount,
                    'quantity' => 1,
                    'name'     => 'Pembayaran Pesanan #' . $order->id,
                ],
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            $order->update(['snap_token' => $snapToken]);
            return $snapToken;
        } catch (\Throwable $e) {
            Log::error('Midtrans Snap Token Exception: ' . $e->getMessage(), [
                'order_id' => $order->id,
                'params'   => $params,
            ]);
            throw $e;
        }
    }

    /**
     * Verify SHA512 signature from Midtrans webhook.
     */
    public function verifySignature(string $orderId, string $statusCode, string $grossAmount, string $signatureKey): bool
    {
        $serverKey = config('services.midtrans.server_key');
        $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);
        return hash_equals($expectedSignature, $signatureKey);
    }

    /**
     * Handle incoming Midtrans Webhook Notification.
     */
    public function handleNotification(array $payload): array
    {
        $orderId = $payload['order_id'] ?? null;
        $statusCode = $payload['status_code'] ?? null;
        $grossAmount = $payload['gross_amount'] ?? null;
        $signatureKey = $payload['signature_key'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $fraudStatus = $payload['fraud_status'] ?? null;
        $paymentType = $payload['payment_type'] ?? 'midtrans';

        if (!$orderId || !$statusCode || !$grossAmount || !$signatureKey) {
            return [
                'status'  => 'error',
                'message' => 'Missing required notification payload fields.',
            ];
        }

        if (!$this->verifySignature($orderId, $statusCode, $grossAmount, $signatureKey)) {
            Log::warning('Midtrans Webhook: Invalid signature', $payload);
            return [
                'status'  => 'error',
                'message' => 'Invalid signature key.',
            ];
        }

        // Handle Midtrans portal test ping / simulator test notification
        if (str_starts_with($orderId, 'payment_notif_test') || str_contains($orderId, 'test_') || str_starts_with($orderId, 'test-')) {
            Log::info('Midtrans Webhook: Test notification acknowledged successfully for ' . $orderId);
            return [
                'status'  => 'success',
                'message' => 'Midtrans test notification acknowledged.',
            ];
        }

        // Parse local order ID from "ORDER-{id}-{timestamp}" or "ORD-{id}-..."
        $realOrderId = null;
        if (preg_match('/^(?:ORDER|ORD)-(\d+)/i', $orderId, $matches)) {
            $realOrderId = (int) $matches[1];
        }

        if (!$realOrderId) {
            Log::warning('Midtrans Webhook: Could not determine local order ID from ' . $orderId, $payload);
            return [
                'status'  => 'ignored',
                'message' => 'Could not determine local order ID from ' . $orderId,
            ];
        }

        $order = Order::find($realOrderId);
        if (!$order) {
            Log::warning('Midtrans Webhook: Order #' . $realOrderId . ' not found in database.', $payload);
            return [
                'status'  => 'ignored',
                'message' => 'Order #' . $realOrderId . ' not found in database.',
            ];
        }

        // Process successful transactions (settlement or capture without challenge)
        $isSuccess = ($transactionStatus === 'settlement') ||
                     ($transactionStatus === 'capture' && $fraudStatus === 'accept');

        if ($isSuccess) {
            $paidAmount = (int) round((float) $grossAmount);

            DB::transaction(function () use ($order, $paidAmount, $paymentType, $orderId) {
                // Check if payment already exists for this transaction to avoid duplicates
                $alreadyExists = Payment::where('order_id', $order->id)
                    ->where('keterangan', 'like', "%{$orderId}%")
                    ->exists();

                if (!$alreadyExists) {
                    Payment::create([
                        'order_id'      => $order->id,
                        'user_id'       => $order->user_id,
                        'jumlah'        => $paidAmount,
                        'metode'        => substr('midtrans_' . $paymentType, 0, 30),
                        'bukti'         => null,
                        'keterangan'    => 'Pembayaran otomatis via Midtrans (' . $orderId . ')',
                        'tanggal_bayar' => now(),
                    ]);
                }

                // Deduct stock if not yet deducted
                if (!$order->stock_deducted) {
                    $order->loadMissing('items.product');
                    foreach ($order->items as $item) {
                        if ($item->product_id) {
                            $product = \App\Models\Product::lockForUpdate()->find($item->product_id);
                            if ($product) {
                                $product->decrement('stock', min($product->stock, $item->quantity));
                            }
                        }
                    }
                    $order->stock_deducted = true;
                }

                // Update order payment status
                $order->payment_status = 'verified';
                $order->payment_verified_at = now();
                $order->save();
            });

            Log::info("Midtrans Webhook: Payment recorded for Order #{$order->id}, amount: {$paidAmount}");

            return [
                'status'  => 'success',
                'message' => 'Payment recorded successfully.',
            ];
        }

        return [
            'status'  => 'ignored',
            'message' => 'Transaction status ' . $transactionStatus . ' received without settlement.',
        ];
    }
}
