<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    /**
     * Record a payment within a transaction.
     * Validates amount against remaining balance with lockForUpdate.
     *
     * @throws \Exception if amount exceeds remaining balance
     */
    public static function recordPayment(array $data): Payment
    {
        return DB::transaction(function () use ($data) {
            $order = Order::lockForUpdate()->findOrFail($data['order_id']);
            $sisaTagihan = $order->sisa_tagihan;

            if ($data['jumlah'] > $sisaTagihan) {
                throw new \Exception(
                    'Jumlah pembayaran (Rp ' . number_format($data['jumlah'], 0, ',', '.') .
                    ') melebihi sisa tagihan (Rp ' . number_format($sisaTagihan, 0, ',', '.') . ').'
                );
            }

            return Payment::create($data);
        });
    }
}
