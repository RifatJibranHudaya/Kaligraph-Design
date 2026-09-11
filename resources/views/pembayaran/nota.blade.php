<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nota Pembayaran #PAY-{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }} — Kaligraph Design</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary: #6366f1;
      --primary-dark: #4f46e5;
      --success: #10b981;
      --warning: #f59e0b;
      --danger: #ef4444;
      --dark: #0f172a;
      --gray-50: #f8fafc;
      --gray-100: #f1f5f9;
      --gray-200: #e2e8f0;
      --gray-400: #94a3b8;
      --gray-600: #475569;
      --gray-800: #1e293b;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      background: #0b0f19;
      color: var(--gray-800);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 30px 15px;
    }

    .no-print-bar {
      width: 100%;
      max-width: 580px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
      gap: 12px;
    }

    .btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 10px 20px;
      border-radius: 12px;
      font-weight: 700;
      font-size: 14px;
      cursor: pointer;
      text-decoration: none;
      transition: all 0.2s ease;
      border: none;
    }

    .btn-primary {
      background: linear-gradient(135deg, #6366f1, #4f46e5);
      color: #ffffff;
      box-shadow: 0 4px 14px rgba(99, 102, 241, 0.4);
    }
    .btn-primary:hover {
      background: linear-gradient(135deg, #4f46e5, #4338ca);
      transform: translateY(-1px);
    }

    .btn-secondary {
      background: rgba(255, 255, 255, 0.1);
      color: #e2e8f0;
      border: 1px solid rgba(255, 255, 255, 0.2);
    }
    .btn-secondary:hover {
      background: rgba(255, 255, 255, 0.18);
      color: #ffffff;
    }

    .receipt-container {
      width: 100%;
      max-width: 580px;
      background: #ffffff;
      border-radius: 20px;
      padding: 36px 32px;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
      position: relative;
      overflow: hidden;
    }

    .receipt-top-stripe {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 6px;
      background: linear-gradient(90deg, #6366f1, #ec4899, #f59e0b);
    }

    .brand-header {
      text-align: center;
      border-bottom: 2px dashed var(--gray-200);
      padding-bottom: 20px;
      margin-bottom: 22px;
    }

    .brand-logo {
      font-size: 24px;
      font-weight: 800;
      letter-spacing: -0.5px;
      color: var(--dark);
      display: inline-flex;
      align-items: center;
      gap: 6px;
    }

    .brand-tagline {
      font-size: 11px;
      text-transform: uppercase;
      letter-spacing: 1.5px;
      font-weight: 700;
      color: var(--primary);
      margin-top: 2px;
    }

    .brand-address {
      font-size: 12px;
      color: var(--gray-600);
      margin-top: 6px;
      line-height: 1.4;
    }

    .receipt-title-box {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: var(--gray-50);
      border: 1px solid var(--gray-200);
      border-radius: 12px;
      padding: 12px 16px;
      margin-bottom: 20px;
    }

    .receipt-num {
      font-family: 'JetBrains Mono', monospace;
      font-weight: 700;
      font-size: 14px;
      color: var(--dark);
    }

    .receipt-date {
      font-size: 12px;
      color: var(--gray-600);
      font-weight: 500;
    }

    .badge-status {
      display: inline-block;
      padding: 4px 10px;
      border-radius: 9999px;
      font-size: 11px;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .badge-lunas {
      background: #dcfce7;
      color: #15803d;
      border: 1px solid #bbf7d0;
    }
    .badge-dp {
      background: #fef3c7;
      color: #b45309;
      border: 1px solid #fde68a;
    }

    .info-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
      margin-bottom: 22px;
    }

    .info-block {
      background: var(--gray-50);
      border-radius: 12px;
      padding: 12px 14px;
      border: 1px solid var(--gray-100);
    }

    .info-label {
      font-size: 11px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: var(--gray-400);
      font-weight: 700;
      margin-bottom: 4px;
    }

    .info-val {
      font-size: 13px;
      font-weight: 600;
      color: var(--dark);
      line-height: 1.35;
      word-break: break-word;
    }

    .bill-card {
      border: 1px solid var(--gray-200);
      border-radius: 14px;
      overflow: hidden;
      margin-bottom: 22px;
    }

    .bill-header {
      background: var(--gray-800);
      color: #ffffff;
      padding: 10px 16px;
      font-size: 12px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      display: flex;
      justify-content: space-between;
    }

    .bill-row {
      display: flex;
      justify-content: space-between;
      padding: 10px 16px;
      font-size: 13px;
      border-bottom: 1px solid var(--gray-100);
      color: var(--gray-600);
    }

    .bill-row:last-child {
      border-bottom: none;
    }

    .bill-row.highlight {
      background: rgba(99, 102, 241, 0.05);
      color: var(--dark);
      font-weight: 700;
      font-size: 15px;
    }

    .bill-row.remaining {
      background: var(--gray-50);
      font-weight: 700;
    }

    .amount-val {
      font-family: 'JetBrains Mono', monospace;
      font-weight: 700;
    }

    .amount-val.primary {
      color: var(--primary);
    }
    .amount-val.success {
      color: var(--success);
    }
    .amount-val.warning {
      color: var(--warning);
    }

    .payment-note {
      background: #fffbeb;
      border: 1px solid #fef3c7;
      border-radius: 10px;
      padding: 10px 14px;
      font-size: 12px;
      color: #92400e;
      margin-bottom: 22px;
      line-height: 1.4;
    }

    .footer-signatures {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
      margin-top: 24px;
      padding-top: 18px;
      border-top: 2px dashed var(--gray-200);
      text-align: center;
    }

    .signature-title {
      font-size: 11px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: var(--gray-400);
      font-weight: 700;
    }

    .signature-space {
      height: 48px;
    }

    .signature-name {
      font-size: 12px;
      font-weight: 700;
      color: var(--dark);
      border-top: 1px solid var(--gray-200);
      display: inline-block;
      min-width: 140px;
      padding-top: 4px;
    }

    .terms-text {
      text-align: center;
      font-size: 10px;
      color: var(--gray-400);
      margin-top: 20px;
      line-height: 1.4;
    }

    /* Print Stylesheet */
    @media print {
      body {
        background: #ffffff !important;
        padding: 0 !important;
      }
      .no-print, .no-print-bar {
        display: none !important;
      }
      .receipt-container {
        box-shadow: none !important;
        border: 1px solid #cbd5e1 !important;
        max-width: 100% !important;
        padding: 24px 20px !important;
        border-radius: 0 !important;
      }
      @page {
        size: auto;
        margin: 10mm 15mm;
      }
    }
  </style>
</head>
<body>

  <!-- Top Action Bar (hidden on print) -->
  <div class="no-print-bar">
    <a href="{{ route('pembayaran.index') }}" class="btn btn-secondary">
      ⬅ Kembali ke Pembayaran
    </a>
    <button type="button" onclick="window.print()" class="btn btn-primary">
      🖨️ Cetak / Print Nota
    </button>
  </div>

  <!-- Printable Receipt Card -->
  <div class="receipt-container">
    <div class="receipt-top-stripe"></div>

    <!-- Header & Brand -->
    <div class="brand-header">
      <div class="brand-logo">
        ✨ KALIGRAPH DESIGN
      </div>
      <div class="brand-tagline">
        Advertising &bull; Neon Box &bull; Huruf Timbul &bull; Signage
      </div>
      <div class="brand-address">
        {{ $order && $order->branch ? $order->branch->nama_cabang : 'Pusat Workshop & Showroom' }}<br>
        {{ $order && $order->branch && $order->branch->alamat ? $order->branch->alamat : 'Demak - Jawa Tengah, Indonesia' }} &bull; WA: {{ $order && $order->branch && $order->branch->no_hp ? $order->branch->no_hp : '0812-3456-7890' }}
      </div>
    </div>

    <!-- Nota Reference & Status -->
    <div class="receipt-title-box">
      <div>
        <div style="font-size:10px; text-transform:uppercase; color:var(--gray-400); font-weight:700;">Bukti Pembayaran</div>
        <div class="receipt-num">#PAY-{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}</div>
      </div>
      <div style="text-align:right;">
        <div class="receipt-date">
          {{ $payment->tanggal_bayar ? $payment->tanggal_bayar->format('d/m/Y') : date('d/m/Y') }}
        </div>
        <div style="margin-top:4px;">
          @if($isLunas)
            <span class="badge-status badge-lunas">✅ LUNAS</span>
          @else
            <span class="badge-status badge-dp">⏳ DP / ANGSURAN</span>
          @endif
        </div>
      </div>
    </div>

    <!-- Customer & Order Info -->
    <div class="info-grid">
      <div class="info-block">
        <div class="info-label">👤 Data Pelanggan</div>
        <div class="info-val">{{ $order ? $order->nama_pelanggan : 'Pelanggan Umum' }}</div>
        @if($order && $order->no_hp)
          <div style="font-size:12px; color:var(--gray-600); margin-top:2px;">📞 {{ $order->no_hp }}</div>
        @endif
        @if($order && $order->alamat)
          <div style="font-size:11px; color:var(--gray-400); margin-top:3px;">📍 {{ $order->alamat }}</div>
        @endif
      </div>

      <div class="info-block">
        <div class="info-label">📋 Rincian Pesanan</div>
        <div class="info-val">Order #ORD-{{ str_pad($order ? $order->id : $payment->order_id, 5, '0', STR_PAD_LEFT) }}</div>
        @if($order && $order->kategori)
          <div style="font-size:12px; color:var(--primary); font-weight:600; margin-top:2px;">📂 {{ $order->kategori }}</div>
        @endif
        @if($order && $order->keterangan)
          <div style="font-size:11px; color:var(--gray-400); margin-top:3px;">📝 {{ Str::limit($order->keterangan, 50) }}</div>
        @endif
      </div>
    </div>

    <!-- Financial Table -->
    <div class="bill-card">
      <div class="bill-header">
        <span>Keterangan Pembayaran</span>
        <span>Nominal (Rp)</span>
      </div>
      <div class="bill-row">
        <span>Total Nilai Tagihan Order</span>
        <span class="amount-val">Rp {{ number_format($orderTotal, 0, ',', '.') }}</span>
      </div>
      <div class="bill-row highlight">
        <span>
          Pembayaran Saat Ini 
          <span style="font-size:11px; font-weight:normal; text-transform:uppercase; color:var(--primary);">
            ({{ $payment->metode === 'dp' ? 'Uang Muka / DP' : ($payment->metode === 'transfer' ? 'Transfer Bank / QRIS' : 'Tunai / Cash') }})
          </span>
        </span>
        <span class="amount-val primary">Rp {{ number_format($payment->jumlah, 0, ',', '.') }}</span>
      </div>
      <div class="bill-row">
        <span>Total Telah Terbayar (Kumulatif)</span>
        <span class="amount-val success">Rp {{ number_format($totalPaid, 0, ',', '.') }}</span>
      </div>
      <div class="bill-row remaining">
        <span>Sisa Tagihan Belum Terbayar</span>
        <span class="amount-val {{ $sisaTagihan > 0 ? 'warning' : 'success' }}">
          Rp {{ number_format($sisaTagihan, 0, ',', '.') }}
        </span>
      </div>
    </div>

    <!-- Notes if any -->
    @if($payment->keterangan)
      <div class="payment-note">
        <strong>📌 Catatan Pembayaran:</strong> {{ $payment->keterangan }}
      </div>
    @endif

    <!-- Signatures -->
    <div class="footer-signatures">
      <div>
        <div class="signature-title">Pelanggan</div>
        <div class="signature-space"></div>
        <div class="signature-name">{{ $order ? $order->nama_pelanggan : 'Pelanggan' }}</div>
      </div>
      <div>
        <div class="signature-title">Kasir / Penerima</div>
        <div class="signature-space"></div>
        <div class="signature-name">{{ $payment->user ? $payment->user->username : 'Admin Workshop' }}</div>
      </div>
    </div>

    <!-- Small Terms Footer -->
    <div class="terms-text">
      Terima kasih telah mempercayakan pengerjaan advertising Anda kepada Kaligraph Design.<br>
      Simpan bukti transaksi ini sebagai bukti pembayaran yang sah.
    </div>
  </div>

</body>
</html>
