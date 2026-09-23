<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Gunakan Storage Facade
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
        // Strip non-digit characters if formatted with dots
        if ($request->has('jumlah') && is_string($request->jumlah)) {
            $cleanedJumlah = preg_replace('/[^\d]/', '', $request->jumlah);
            $request->merge(['jumlah' => $cleanedJumlah !== '' ? $cleanedJumlah : 0]);
        }

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
            'jumlah.min'             => 'Jumlah pembayaran minimal Rp 1.',
            'tanggal_bayar.required' => 'Tanggal bayar wajib diisi.',
            'bukti.image'            => 'File bukti harus berupa gambar.',
            'bukti.max'              => 'Ukuran bukti maksimal 3 MB.',
        ]);

        $order = Order::findOrFail($validated['order_id']);
        $sisaTagihan = $order->sisa_tagihan;

        if ($validated['jumlah'] > $sisaTagihan) {
            return back()->withInput()->withErrors([
                'jumlah' => 'Jumlah pembayaran (Rp ' . number_format($validated['jumlah'], 0, ',', '.') . ') tidak boleh melebihi sisa tagihan (Maks: Rp ' . number_format($sisaTagihan, 0, ',', '.') . ').'
            ]);
        }

        $validated['user_id'] = Auth::id();

        // SIMPAN BUKTI PEMBAYARAN KE STORAGE
        if ($request->hasFile('bukti')) {
            $file = $request->file('bukti');
            $filename = 'pay_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            
            // Disimpan di storage/app/public/payments/
            $file->storeAs('receipts', $filename, 'public');
            
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

        // Redirect ke detail order jika request berasal dari halaman detail
        if ($request->filled('redirect_to_detail')) {
            return redirect()->route('pembayaran.detail.order', $validated['order_id'])
                ->with('success', 'Pembayaran berhasil dicatat.');
        }

        return back()->with('success', "Pembayaran berhasil dicatat.");
    }

    public function destroy(Payment $payment)
    {
        $orderId = $payment->order_id;
        $jumlah = $payment->jumlah;

        // HAPUS BUKTI PEMBAYARAN DARI STORAGE
        if ($payment->bukti && Storage::disk('public')->exists('payments/' . $payment->bukti)) {
            Storage::disk('public')->delete('payments/' . $payment->bukti);
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

    /**
     * Display detail pembayaran untuk sebuah order dengan form pembayaran dan tombol kirim WA.
     */
    public function detailOrder(Order $order)
    {
        $order->load(['branch', 'user', 'items', 'payments.user']);
        
        // Cek authorization: hanya user yang terkait dengan order ini atau admin yang bisa akses
        $authUser = Auth::guard('customer')->user() ?: Auth::guard('web')->user();
        
        if (!$authUser) {
            return redirect()->route('login.customer')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        // Jika customer, pastikan hanya bisa melihat ordernya sendiri
        if ($authUser->isCustomer() && $order->user_id !== $authUser->id) {
            return redirect()->route('customer.dashboard')->with('error', 'Anda tidak memiliki akses ke order ini.');
        }
        
        $allPayments = $order->payments()->orderBy('id')->get();
        $totalPaid = $order->total_dibayar;
        $orderTotal = (int) $order->total;
        $sisaTagihan = max(0, $orderTotal - $totalPaid);
        $isLunas = $sisaTagihan <= 0;

        // Tentukan view berdasarkan tipe user
        $view = $authUser->isCustomer() ? 'customer.detail-order' : 'pembayaran.detail-order';

        return view($view, compact(
            'order',
            'allPayments',
            'totalPaid',
            'orderTotal',
            'sisaTagihan',
            'isLunas'
        ));
    }

    /**
     * Kirim nota dan progress order ke WhatsApp pelanggan.
     */
    public function sendWhatsapp(Order $order, Request $request)
    {
        // Cek authorization
        $authUser = Auth::guard('customer')->user() ?: Auth::guard('web')->user();
        
        if (!$authUser) {
            return redirect()->route('login.customer')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        // Jika customer, pastikan hanya bisa mengirim WA untuk ordernya sendiri
        if ($authUser->isCustomer() && $order->user_id !== $authUser->id) {
            return redirect()->route('customer.dashboard')->with('error', 'Anda tidak memiliki akses ke order ini.');
        }

        $validated = $request->validate([
            'nomor_wa' => 'required|string',
            'pesan_tambahan' => 'nullable|string|max:500',
        ]);

        // Hitung total pembayaran dan sisa tagihan
        $totalPaid = $order->total_dibayar;
        $orderTotal = (int) $order->total;
        $sisaTagihan = max(0, $orderTotal - $totalPaid);
        $isLunas = $sisaTagihan <= 0;

        // Ambil semua pembayaran untuk order ini
        $payments = $order->payments()->orderBy('id')->get();

        // Format pesan nota
        $notaText = "*NOTA PEMBAYARAN ORDER #{$order->id}*\n\n";
        $notaText .= "━━━━━━━━━━━━━━━━━━━━\n";
        $notaText .= "📋 *Detail Order*\n";
        $notaText .= "━━━━━━━━━━━━━━━━━━━━\n";
        $notaText .= "Nama Pelanggan: {$order->nama_pelanggan}\n";
        $noHpVal = $order->no_hp ?: '-';
        $kategoriVal = $order->kategori ?: '-';
        $alamatVal = $order->alamat ?: '-';
        $notaText .= "No. HP: {$noHpVal}\n";
        $notaText .= "Kategori: {$kategoriVal}\n";
        $notaText .= "Alamat: {$alamatVal}\n\n";
        
        $notaText .= "💰 *Rincian Pembayaran*\n";
        $notaText .= "━━━━━━━━━━━━━━━━━━━━\n";
        $notaText .= "Total Tagihan: Rp " . number_format($orderTotal, 0, ',', '.') . "\n";
        $notaText .= "Total Dibayar: Rp " . number_format($totalPaid, 0, ',', '.') . "\n";
        $notaText .= "Sisa Tagihan: Rp " . number_format($sisaTagihan, 0, ',', '.') . "\n";
        $notaText .= "Status: *" . ($isLunas ? 'LUNAS ✅' : 'BELUM LUNAS ⏳') . "*\n\n";

        if ($payments->count() > 0) {
            $notaText .= "📝 *Riwayat Pembayaran*\n";
            $notaText .= "━━━━━━━━━━━━━━━━━━━━\n";
            foreach ($payments as $pay) {
                $tanggal = $pay->tanggal_bayar ? $pay->tanggal_bayar->format('d/m/Y') : '-';
                $notaText .= "• {$tanggal} - Rp " . number_format($pay->jumlah, 0, ',', '.');
                $notaText .= " ({$pay->metode})\n";
            }
            $notaText .= "\n";
        }

        $notaText .= "🔧 *Status Pengerjaan*\n";
        $notaText .= "━━━━━━━━━━━━━━━━━━━━\n";
        $statusLabels = [
            'order' => 'Order Baru',
            'on_progress' => 'Sedang Dikerjakan',
            'selesai' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];
        $statusLabel = isset($statusLabels[$order->status]) ? $statusLabels[$order->status] : $order->status;
        $notaText .= "Status: *{$statusLabel}*\n";
        $keteranganVal = $order->keterangan ?: '-';
        $notaText .= "Keterangan: {$keteranganVal}\n\n";

        // Tambahkan pesan tambahan jika ada
        if (!empty($validated['pesan_tambahan'])) {
            $notaText .= "📩 *Pesan Tambahan*\n";
            $notaText .= "━━━━━━━━━━━━━━━━━━━━\n";
            $notaText .= $validated['pesan_tambahan'] . "\n\n";
        }

        $notaText .= "━━━━━━━━━━━━━━━━━━━━\n";
        $notaText .= "Terima kasih atas kepercayaan Anda!\n";
        $notaText .= "Kafa Advertising - Professional Signage & Neon Box";

        // Format nomor WA
        $nomorWa = \App\Helpers\FormatHelper::cleanWhatsappNumber($validated['nomor_wa']);

        // Buat URL WhatsApp dengan pesan yang sudah diformat
        $waUrl = 'https://wa.me/' . $nomorWa . '?text=' . urlencode($notaText);

        ActivityLogService::log(
            'send_whatsapp_nota',
            'pembayaran',
            "Kirim nota Order #{$order->id} ke WA {$validated['nomor_wa']}",
            $order->id
        );

        // Redirect ke halaman detail dengan pesan sukses dan URL WA
        $redirectRoute = $authUser->isCustomer() ? 'customer.order.detail' : 'pembayaran.detail.order';
        
        return redirect()->route($redirectRoute, $order->id)
            ->with('success', 'Nota berhasil disiapkan!')
            ->with('wa_url', $waUrl)
            ->with('nomor_wa', $validated['nomor_wa']);
    }

    /**
     * Admin: Verify uploaded receipt and optionally adjust order total.
     */
    public function verifyReceipt(Request $request, Order $order)
    {
        // Ensure admin/staff user
        $authUser = Auth::guard('web')->user();
        if (!$authUser) {
            return redirect()->route('login.admin')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Validate inputs: optional new_total, and required verification action
        $validated = $request->validate([
            'new_total' => 'nullable|numeric|min:0',
        ]);

        // Update order total if provided
        if (isset($validated['new_total'])) {
            $order->total = $validated['new_total'];
        }

        // Mark receipt as verified
        $order->payment_status = 'verified';
        $order->payment_verified_by = $authUser->id;
        $order->payment_verified_at = now();
        $order->save();

        ActivityLogService::log(
            'verify_receipt',
            'pembayaran',
            "Verifikasi bukti pembayaran untuk Order #{$order->id}",
            $order->id
        );

        return redirect()->route('pembayaran.detail.order', $order->id)
            ->with('success', 'Bukti pembayaran berhasil diverifikasi.');
    }

    public function customerUploadReceipt(Request $request, Order $order)
    {
        $authUser = Auth::guard('customer')->user() ?: Auth::guard('web')->user();
        if (!$authUser) {
            return redirect()->route('login.customer')->with('error', 'Silakan login terlebih dahulu.');
        }
        // Ensure the customer can only access their own order
        if ($authUser->isCustomer() && $order->user_id !== $authUser->id) {
            return redirect()->route('customer.dashboard')->with('error', 'Anda tidak memiliki akses ke order ini.');
        }

        $validated = $request->validate([
            'bukti' => 'required|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        // UPLOAD RECEIPT KE STORAGE
        if ($request->hasFile('bukti')) {
            // Hapus file receipt lama jika ada
            if ($order->receipt_path && Storage::disk('public')->exists('receipts/' . $order->receipt_path)) {
                Storage::disk('public')->delete('receipts/' . $order->receipt_path);
            }

            $file = $request->file('bukti');
            $filename = 'receipt_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            
            // Disimpan di storage/app/public/receipts/
            $file->storeAs('receipts', $filename, 'public');

            $order->receipt_path = $filename;
            $order->payment_status = 'pending';
            $order->save();

            ActivityLogService::log(
                'upload_receipt',
                'pembayaran',
                "Upload bukti pembayaran untuk Order #{$order->id}",
                $order->id
            );
        }

        return redirect()->route($authUser->isCustomer() ? 'customer.order.detail' : 'pembayaran.detail.order', $order->id)
            ->with('success', 'Bukti pembayaran berhasil diunggah, menunggu verifikasi.');
    }
}