@extends('layouts.guest')

@section('title', 'Bayar Online Midtrans Order #' . $order->id . ' — Kafa Advertising')

@section('styles')
<style>
  .mt-wrap {
    min-height: 100vh;
    background: #f4f7fb;
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: #0f172a;
  }

  .mt-nav {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(12px);
    border-bottom: 1px solid #e2e8f0;
    padding: 0 6%;
    height: 64px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: sticky;
    top: 0;
    z-index: 100;
  }

  .mt-brand {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 18px;
    font-weight: 800;
    color: #0064e0;
    text-decoration: none;
  }

  .mt-brand-badge {
    width: 36px;
    height: 36px;
    background: linear-gradient(135deg, #2563eb, #4f46e5);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-weight: 800;
  }

  .mt-nav-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    font-size: 13.5px;
    font-weight: 700;
    color: #475569;
    background: #fff;
    border: 1px solid #cbd5e1;
    border-radius: 10px;
    text-decoration: none;
    transition: all 0.2s;
  }
  .mt-nav-link:hover {
    color: #0064e0;
    border-color: #93c5fd;
    background: #eff6ff;
  }

  .mt-container {
    max-width: 1080px;
    margin: 0 auto;
    padding: 32px 20px 80px;
  }

  /* Hero header */
  .mt-hero {
    background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%);
    color: #fff;
    border-radius: 20px;
    padding: 28px 32px;
    margin-bottom: 24px;
    box-shadow: 0 12px 30px rgba(49, 46, 129, 0.25);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
  }

  .mt-hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.25);
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .mt-hero-title {
    font-size: 24px;
    font-weight: 800;
    margin: 0 0 6px;
    letter-spacing: -0.5px;
  }

  .mt-hero-sub {
    font-size: 13.5px;
    color: rgba(255,255,255,0.8);
    margin: 0;
  }

  .mt-status-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 18px;
    border-radius: 30px;
    font-size: 13px;
    font-weight: 800;
    letter-spacing: 0.5px;
  }
  .status-pill-pending {
    background: #fef3c7;
    color: #92400e;
    border: 1px solid #fcd34d;
  }
  .status-pill-lunas {
    background: #d1fae5;
    color: #065f46;
    border: 1px solid #6ee7b7;
  }

  /* Grid layout */
  .mt-grid {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 24px;
    align-items: start;
  }

  @media(max-width: 860px) {
    .mt-grid {
      grid-template-columns: 1fr;
    }
  }

  /* Cards */
  .mt-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 18px;
    box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
    margin-bottom: 20px;
    overflow: hidden;
  }

  .mt-card-header {
    padding: 16px 22px;
    border-bottom: 1px solid #f1f5f9;
    font-size: 15px;
    font-weight: 800;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 8px;
    background: #fafbfc;
  }

  .mt-card-body {
    padding: 22px;
  }

  /* Items Table */
  .mt-item-row {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 14px 0;
    border-bottom: 1px solid #f1f5f9;
  }
  .mt-item-row:last-child {
    border-bottom: none;
    padding-bottom: 0;
  }
  .mt-item-row:first-child {
    padding-top: 0;
  }

  .mt-item-thumb {
    width: 64px;
    height: 64px;
    border-radius: 12px;
    background: #f1f5f9;
    object-fit: cover;
    flex-shrink: 0;
    border: 1px solid #e2e8f0;
  }
  .mt-item-thumb-box {
    width: 64px;
    height: 64px;
    border-radius: 12px;
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    flex-shrink: 0;
  }

  .mt-item-info {
    flex: 1;
    min-width: 0;
  }
  .mt-item-title {
    font-weight: 700;
    font-size: 14.5px;
    color: #1e293b;
    margin-bottom: 2px;
  }
  .mt-item-meta {
    font-size: 12px;
    color: #64748b;
  }

  .mt-item-subtotal {
    text-align: right;
    font-weight: 800;
    font-size: 15px;
    color: #0f172a;
    flex-shrink: 0;
  }

  /* Channels reassurance badge */
  .payment-channels-box {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 16px;
    margin-top: 18px;
  }
  .payment-channels-title {
    font-size: 12px;
    font-weight: 800;
    text-transform: uppercase;
    color: #64748b;
    letter-spacing: 0.5px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 6px;
  }
  .payment-badges-list {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
  }
  .p-badge {
    background: #fff;
    border: 1px solid #cbd5e1;
    padding: 5px 10px;
    border-radius: 8px;
    font-size: 11.5px;
    font-weight: 700;
    color: #334155;
    display: inline-flex;
    align-items: center;
    gap: 5px;
  }

  /* Right Column Summary */
  .summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    font-size: 14px;
    border-bottom: 1px dashed #e2e8f0;
  }
  .summary-row:last-child {
    border-bottom: none;
  }
  .summary-label {
    color: #64748b;
  }
  .summary-val {
    font-weight: 700;
    color: #1e293b;
  }
  .summary-val.highlight {
    font-size: 18px;
    font-weight: 800;
    color: #4338ca;
  }

  .btn-pay-midtrans {
    width: 100%;
    padding: 14px 20px;
    background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
    color: #fff;
    border: none;
    border-radius: 12px;
    font-size: 15px;
    font-weight: 800;
    cursor: pointer;
    box-shadow: 0 6px 20px rgba(79, 70, 229, 0.35);
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-top: 18px;
  }
  .btn-pay-midtrans:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(79, 70, 229, 0.45);
  }
  .btn-pay-midtrans:disabled {
    background: #94a3b8;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
  }

  .btn-cancel-order {
    width: 100%;
    padding: 10px 14px;
    background: transparent;
    border: 1px solid #cbd5e1;
    color: #64748b;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
    text-align: center;
    margin-top: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
  }
  .btn-cancel-order:hover {
    background: #fee2e2;
    border-color: #fca5a5;
    color: #dc2626;
  }

  .notice-safe-pay {
    font-size: 11.5px;
    color: #64748b;
    text-align: center;
    margin-top: 12px;
    line-height: 1.5;
  }

  .alert-mt {
    padding: 12px 16px;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 600;
    margin-top: 14px;
    display: none;
  }
  .alert-mt-success { background:#d1fae5; color:#065f46; border:1px solid #86efac; }
  .alert-mt-warning { background:#fef3c7; color:#92400e; border:1px solid #fcd34d; }
  .alert-mt-error   { background:#fee2e2; color:#991b1b; border:1px solid #fca5a5; }
</style>
@endsection

@section('content')
<div class="mt-wrap">
  <!-- Navbar -->
  <nav class="mt-nav">
    <a href="{{ route('customer.dashboard') }}" class="mt-brand">
      <div class="mt-brand-badge">K</div>
      <span>Kafa Advertising</span>
    </a>
    <div style="display:flex; align-items:center; gap:10px;">
      <a href="{{ route('customer.dashboard') }}" class="mt-nav-link">
        <i class="bi bi-grid"></i> Dashboard
      </a>
      <a href="{{ route('katalog') }}" class="mt-nav-link">
        <i class="bi bi-bag"></i> Katalog
      </a>
    </div>
  </nav>

  <div class="mt-container">
    <!-- Hero Header -->
    <div class="mt-hero">
      <div>
        <div class="mt-hero-badge"><i class="bi bi-shield-check"></i> Gateway Pembayaran Otomatis</div>
        <h1 class="mt-hero-title">Pembayaran Online Midtrans #{{ $order->id }}</h1>
        <p class="mt-hero-sub">
          Dipesan pada {{ $order->created_at->format('d M Y, H:i') }} • Pelanggan: <strong>{{ $order->nama_pelanggan }}</strong>
        </p>
      </div>
      <div>
        @if($isLunas)
          <div class="mt-status-pill status-pill-lunas">
            <i class="bi bi-check-circle-fill"></i> LUNAS (TERVERIFIKASI)
          </div>
        @else
          <div class="mt-status-pill status-pill-pending">
            <i class="bi bi-hourglass-split"></i> MENUNGGU PEMBAYARAN
          </div>
        @endif
      </div>
    </div>

    @if(session('success'))
      <div style="padding:14px 18px; border-radius:12px; background:#d1fae5; color:#065f46; font-size:14px; font-weight:700; margin-bottom:20px; border:1px solid #86efac;">
        <i class="bi bi-check-circle-fill" style="margin-right:6px;"></i> {{ session('success') }}
      </div>
    @endif

    @if(session('error'))
      <div style="padding:14px 18px; border-radius:12px; background:#fee2e2; color:#991b1b; font-size:14px; font-weight:700; margin-bottom:20px; border:1px solid #fca5a5;">
        <i class="bi bi-exclamation-triangle-fill" style="margin-right:6px;"></i> {{ session('error') }}
      </div>
    @endif

    <div class="mt-grid">
      <!-- Left Column: Items & Customer Details -->
      <div>
        <!-- Order Items Card -->
        <div class="mt-card">
          <div class="mt-card-header">
            <i class="bi bi-box-seam" style="color:#4f46e5;"></i>
            <span>Daftar Produk E-Commerce ({{ $order->items->count() }} Item)</span>
          </div>
          <div class="mt-card-body">
            @foreach($order->items as $item)
              <div class="mt-item-row">
                @if($item->product && $item->product->foto_url)
                  <img src="{{ $item->product->foto_url }}" alt="{{ $item->produk }}" class="mt-item-thumb">
                @else
                  <div class="mt-item-thumb-box">📦</div>
                @endif
                <div class="mt-item-info">
                  <div class="mt-item-title">{{ $item->produk }}</div>
                  <div class="mt-item-meta">
                    @if($item->product && $item->product->sku)
                      <span style="margin-right:8px;">SKU: {{ $item->product->sku }}</span>
                    @endif
                    <span>Rp {{ number_format($item->unit_price, 0, ',', '.') }} × {{ $item->quantity }} pcs</span>
                  </div>
                </div>
                <div class="mt-item-subtotal">
                  Rp {{ number_format($item->harga, 0, ',', '.') }}
                </div>
              </div>
            @endforeach

            <!-- Payment channels reassurance -->
            <div class="payment-channels-box">
              <div class="payment-channels-title">
                <i class="bi bi-shield-lock-fill" style="color:#4f46e5;"></i>
                <span>Metode Pembayaran Didukung via Midtrans</span>
              </div>
              <div class="payment-badges-list">
                <span class="p-badge"><i class="bi bi-qr-code"></i> QRIS (Semua E-Wallet & Bank)</span>
                <span class="p-badge"><i class="bi bi-bank"></i> BCA Virtual Account</span>
                <span class="p-badge"><i class="bi bi-bank"></i> Mandiri Bill</span>
                <span class="p-badge"><i class="bi bi-bank"></i> BNI / BRI VA</span>
                <span class="p-badge"><i class="bi bi-wallet2"></i> GoPay & ShopeePay</span>
                <span class="p-badge"><i class="bi bi-credit-card"></i> Kartu Kredit / Debit</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Customer & Order Info Card -->
        <div class="mt-card">
          <div class="mt-card-header">
            <i class="bi bi-info-circle" style="color:#4f46e5;"></i>
            <span>Informasi Pemesan & Pengiriman</span>
          </div>
          <div class="mt-card-body">
            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:16px;">
              <div>
                <span style="font-size:12px; color:#64748b; font-weight:600; display:block;">Nama Pemesan</span>
                <strong style="font-size:14px; color:#1e293b;">{{ $order->nama_pelanggan }}</strong>
              </div>
              <div>
                <span style="font-size:12px; color:#64748b; font-weight:600; display:block;">Nomor WhatsApp / HP</span>
                <strong style="font-size:14px; color:#1e293b;">{{ $order->no_hp ?: '-' }}</strong>
              </div>
              <div>
                <span style="font-size:12px; color:#64748b; font-weight:600; display:block;">Alamat Pengiriman</span>
                <strong style="font-size:14px; color:#1e293b;">{{ $order->alamat ?: 'Ambil di Toko / Menyesuaikan' }}</strong>
              </div>
              <div>
                <span style="font-size:12px; color:#64748b; font-weight:600; display:block;">Catatan</span>
                <strong style="font-size:14px; color:#1e293b;">{{ $order->keterangan ?: '-' }}</strong>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Column: Sticky Summary & Pay Button -->
      <div>
        <div class="mt-card" style="position:sticky; top:84px;">
          <div class="mt-card-header">
            <i class="bi bi-receipt" style="color:#4f46e5;"></i>
            <span>Ringkasan Tagihan</span>
          </div>
          <div class="mt-card-body">
            <div class="summary-row">
              <span class="summary-label">Total Pesanan</span>
              <span class="summary-val">Rp {{ number_format($orderTotal, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row">
              <span class="summary-label">Sudah Dibayar</span>
              <span class="summary-val" style="color:#059669;">Rp {{ number_format($totalPaid, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row">
              <span class="summary-label" style="font-weight:700;">Sisa Pembayaran</span>
              <span class="summary-val highlight">
                Rp {{ number_format($sisaTagihan, 0, ',', '.') }}
              </span>
            </div>

            @if($isLunas)
              <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:12px; padding:16px; text-align:center; margin-top:18px;">
                <i class="bi bi-patch-check-fill" style="font-size:36px; color:#16a34a; display:block; margin-bottom:6px;"></i>
                <strong style="color:#166534; font-size:15px; display:block;">Pesanan Telah Lunas</strong>
                <span style="font-size:12px; color:#15803d;">Terima kasih atas pembayaran Anda! Pesanan Anda sedang diproses oleh tim kami.</span>
              </div>
              <a href="{{ route('customer.dashboard') }}" class="btn-pay-midtrans" style="background:#16a34a; text-decoration:none; margin-top:14px;">
                <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
              </a>
            @else
              <button type="button" id="btn-snap-trigger" class="btn-pay-midtrans">
                <i class="bi bi-wallet2"></i> Bayar Sekarang via Midtrans
              </button>

              <div id="mt-alert-box" class="alert-mt"></div>

              <div class="notice-safe-pay">
                <i class="bi bi-lock-fill"></i> Pembayaran instan & terverifikasi otomatis secara real-time via Payment Gateway Midtrans.
              </div>

              <!-- Cancel Order Option -->
              <form action="{{ route('customer.order.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?');">
                @csrf
                <button type="submit" class="btn-cancel-order">
                  <i class="bi bi-x-circle"></i> Batalkan Pesanan
                </button>
              </form>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@if(!$isLunas && \App\Services\MidtransService::isConfigured())
  <script src="{{ \App\Services\MidtransService::getSnapUrl() }}" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
@endif

<script>
  const payBtn = document.getElementById('btn-snap-trigger');
  const alertBox = document.getElementById('mt-alert-box');
  let currentSnapToken = @json($snapToken);

  function showAlert(message, type = 'error') {
    if (!alertBox) return;
    alertBox.style.display = 'block';
    alertBox.className = 'alert-mt alert-mt-' + type;
    alertBox.innerHTML = message;
  }

  function handleSnapSuccess(result) {
    showAlert('<i class="bi bi-hourglass-split"></i> Memverifikasi pembayaran Anda...', 'warning');
    if (payBtn) payBtn.disabled = true;

    // Send confirmation to backend
    fetch("{{ route('customer.order.midtrans.success', $order->id) }}", {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify({ result: result })
    })
    .then(res => res.json())
    .then(data => {
      showAlert('<i class="bi bi-check-circle-fill"></i> Pembayaran Berhasil! Mengalihkan...', 'success');
      setTimeout(() => {
        window.location.reload();
      }, 1500);
    })
    .catch(err => {
      console.error('Success callback error:', err);
      // Even if client post fails, Webhook will record it
      window.location.reload();
    });
  }

  function launchSnap(token) {
    if (!window.snap || typeof window.snap.pay !== 'function') {
      showAlert('<i class="bi bi-exclamation-circle"></i> Library Midtrans Snap belum siap. Silakan refresh halaman.', 'error');
      if (payBtn) payBtn.disabled = false;
      return;
    }

    window.snap.pay(token, {
      onSuccess: function (result) {
        handleSnapSuccess(result);
      },
      onPending: function (result) {
        showAlert('<i class="bi bi-clock-history"></i> Pembayaran sedang diproses. Silakan selesaikan pembayaran sesuai petunjuk.', 'warning');
        setTimeout(() => window.location.reload(), 2500);
      },
      onError: function (result) {
        showAlert('<i class="bi bi-x-circle"></i> Pembayaran gagal atau dibatalkan.', 'error');
        if (payBtn) payBtn.disabled = false;
      },
      onClose: function () {
        // Customer closed modal without paying
        if (payBtn) payBtn.disabled = false;
      }
    });
  }

  if (payBtn) {
    payBtn.addEventListener('click', function () {
      payBtn.disabled = true;
      payBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Menyiapkan Midtrans...';

      if (currentSnapToken) {
        payBtn.innerHTML = '<i class="bi bi-wallet2"></i> Bayar Sekarang via Midtrans';
        launchSnap(currentSnapToken);
        return;
      }

      // Fetch snap token if not yet loaded
      fetch("{{ route('customer.order.snap.token', $order->id) }}", {
        headers: {
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        }
      })
      .then(async res => {
        const data = await res.json().catch(() => null);
        if (!res.ok || !data || data.status === 'error') {
          throw new Error((data && data.message) ? data.message : 'Gagal memuat token pembayaran Midtrans.');
        }
        return data;
      })
      .then(data => {
        currentSnapToken = data.snap_token;
        payBtn.innerHTML = '<i class="bi bi-wallet2"></i> Bayar Sekarang via Midtrans';
        launchSnap(currentSnapToken);
      })
      .catch(err => {
        payBtn.disabled = false;
        payBtn.innerHTML = '<i class="bi bi-wallet2"></i> Bayar Sekarang via Midtrans';
        showAlert('<i class="bi bi-exclamation-triangle"></i> ' + err.message, 'error');
      });
    });
  }
</script>
@endsection
