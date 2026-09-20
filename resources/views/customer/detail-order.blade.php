@extends('layouts.guest')

@section('title', 'Detail Order #' . $order->id . ' â€“ Kafa Advertising')

@section('styles')
<style>
  /* â”€â”€â”€ Wrapper â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
  .co-wrap {
    min-height: 100vh;
    background: #f3f6fb;
    font-family: 'Plus Jakarta Sans', sans-serif;
  }

  /* â”€â”€â”€ Navbar â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
  .co-nav {
    background: #fff;
    border-bottom: 1px solid #e4e8ef;
    padding: 0 5%;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: sticky;
    top: 0;
    z-index: 100;
    box-shadow: 0 1px 6px rgba(0,0,0,.06);
  }
  .co-nav-brand {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 17px;
    font-weight: 800;
    color: #0064e0;
    text-decoration: none;
  }
  .co-nav-brand .icon-box {
    width: 34px; height: 34px;
    background: linear-gradient(135deg,#2563eb,#7c3aed);
    border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 17px; font-weight: 800;
  }
  .co-nav-back {
    font-size: 13px;
    font-weight: 600;
    color: #0064e0;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 7px 14px;
    border: 1.5px solid #0064e0;
    border-radius: 8px;
    transition: background .15s;
  }
  .co-nav-back:hover { background: #e7f1fe; }

  /* â”€â”€â”€ Page body â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
  .co-body {
    max-width: 1060px;
    margin: 0 auto;
    padding: 28px 20px 60px;
  }

  /* â”€â”€â”€ Hero header â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
  .co-hero {
    background: linear-gradient(135deg,#2563eb 0%,#4f8cff 100%);
    color: #fff;
    border-radius: 18px;
    padding: 26px 28px;
    margin-bottom: 24px;
    box-shadow: 0 10px 28px rgba(37,99,235,.28);
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 16px;
  }
  .co-hero-title { font-size: 22px; font-weight: 800; margin-bottom: 6px; }
  .co-hero-sub   { font-size: 13.5px; opacity: .88; }
  .co-hero-right { text-align: right; }

  .co-status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .5px;
  }
  .badge-lunas       { background:#d1fae5; color:#065f46; }
  .badge-belum-lunas { background:#fef3c7; color:#92400e; }

  .co-status-progress {
    margin-top: 10px;
    font-size: 12.5px;
    opacity: .85;
  }
  .co-status-progress strong {
    display: block;
    font-size: 14px;
    font-weight: 700;
    opacity: 1;
    margin-top: 2px;
  }

  /* â”€â”€â”€ Two-column grid â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
  .co-grid {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 20px;
    align-items: start;
  }
  @media(max-width: 768px){
    .co-grid { grid-template-columns: 1fr; }
    .co-sticky { position: static !important; }
  }
  .co-sticky { position: sticky; top: 76px; }

  /* â”€â”€â”€ Card â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
  .co-card {
    background: #fff;
    border: 1px solid #e4e8ef;
    border-radius: 16px;
    overflow: hidden;
    margin-bottom: 18px;
    box-shadow: 0 2px 8px rgba(0,0,0,.04);
  }
  .co-card-head {
    padding: 15px 20px;
    border-bottom: 1px solid #e4e8ef;
    font-size: 14.5px;
    font-weight: 700;
    color: #0a1317;
    display: flex;
    align-items: center;
    gap: 8px;
    background: #fafbfc;
  }
  .co-card-body { padding: 20px; }

  /* â”€â”€â”€ Upload Receipt â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
  .receipt-preview-box {
    border: 1.5px dashed #a5b4fc;
    background: #f0f4ff;
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    margin-bottom: 16px;
  }
  .receipt-preview-box .up-icon { font-size: 36px; margin-bottom: 8px; }
  .receipt-preview-box p { font-size: 13px; color: #5d6c7b; margin: 0; }
  .receipt-preview-box p strong { color: #0064e0; }

  .receipt-uploaded-box {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 16px;
    background: #f0fdf4;
    border: 1.5px solid #86efac;
    border-radius: 12px;
    margin-bottom: 16px;
  }
  .receipt-uploaded-box .ub-icon {
    width: 40px; height: 40px;
    background: #22c55e;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; font-size: 18px;
  }
  .receipt-uploaded-box .ub-info { flex: 1; }
  .receipt-uploaded-box .ub-info strong { font-size: 13.5px; color: #065f46; display: block; }
  .receipt-uploaded-box .ub-info span  { font-size: 12px; color: #16a34a; }

  /* â”€â”€â”€ File input â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
  .file-label-txt {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #0a1317;
    margin-bottom: 8px;
  }
  .file-input-wrap {
    border: 2px dashed #cbd5e1;
    border-radius: 10px;
    padding: 22px;
    text-align: center;
    cursor: pointer;
    transition: border-color .2s, background .2s;
    background: #fafbfc;
    position: relative;
  }
  .file-input-wrap:hover { border-color: #0064e0; background: #f0f4ff; }
  .file-input-wrap input[type="file"] {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
    width: 100%;
    height: 100%;
  }
  .file-input-wrap .fi-icon { font-size: 28px; margin-bottom: 6px; }
  .file-input-wrap .fi-text { font-size: 13px; color: #5d6c7b; }
  .file-input-wrap .fi-text strong { color: #0064e0; }

  /* â”€â”€â”€ Payment history â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
  .pay-item {
    padding: 14px 0;
    border-bottom: 1px solid #f0f0f0;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
  }
  .pay-item:last-child { border-bottom: none; padding-bottom: 0; }
  .pay-item:first-child { padding-top: 0; }

  .pay-badge-pill {
    display: inline-flex;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    margin-bottom: 4px;
  }
  .pay-badge-dp       { background:#fef3c7; color:#92400e; }
  .pay-badge-transfer { background:#dbeafe; color:#1d4ed8; }
  .pay-badge-cash     { background:#d1fae5; color:#065f46; }

  .pay-amount { font-size: 17px; font-weight: 800; color: #059669; }
  .pay-date   { font-size: 11.5px; color: #8595a4; margin-top: 2px; }
  .pay-note   { font-size: 12px; color: #5d6c7b; margin-top: 4px; }
  .pay-actions { display: flex; flex-direction: column; gap: 5px; align-items: flex-end; flex-shrink: 0; }

  /* â”€â”€â”€ Summary rows â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
  .sum-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    font-size: 14px;
    border-bottom: 1px dashed #f0f0f0;
  }
  .sum-row:last-child { border-bottom: none; }
  .sum-label  { color: #5d6c7b; }
  .sum-val    { font-weight: 700; color: #0a1317; }
  .sum-val.danger  { color: #e41e3f; }
  .sum-val.success { color: #059669; }

  /* â”€â”€â”€ Progress bar â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
  .prog-wrap {
    margin: 14px 0;
    padding: 12px 14px;
    background: #f9fafb;
    border-radius: 10px;
    border: 1px solid #e4e8ef;
  }
  .prog-labels {
    display: flex;
    justify-content: space-between;
    font-size: 12px;
    margin-bottom: 6px;
    color: #5d6c7b;
  }
  .prog-labels strong { color: #0064e0; }
  .prog-bar  { height: 10px; background: #e5e7eb; border-radius: 8px; overflow: hidden; }
  .prog-fill { height: 100%; background: linear-gradient(90deg,#10b981,#34d399); border-radius: 8px; transition: width .4s ease; }

  /* â”€â”€â”€ Payment status chip â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
  .pmt-status-chip {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 9px 14px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 700;
    margin-bottom: 16px;
  }
  .chip-pending  { background:#fef3c7; color:#92400e; border:1px solid #fcd34d; }
  .chip-verified { background:#d1fae5; color:#065f46; border:1px solid #6ee7b7; }
  .chip-rejected { background:#fee2e2; color:#991b1b; border:1px solid #fca5a5; }
  .chip-none     { background:#f3f4f6; color:#6b7280; border:1px solid #e5e7eb; }

  /* â”€â”€â”€ Buttons â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
  .btn-co {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    padding: 10px 18px;
    border-radius: 10px;
    font-size: 13.5px;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
    border: none;
    transition: all .18s;
    font-family: inherit;
  }
  .btn-co-primary   { background:#0064e0; color:#fff; }
  .btn-co-primary:hover   { background:#0457cb; }
  .btn-co-secondary { background:#f1f4f7; color:#0a1317; border:1.5px solid #dee3e9; }
  .btn-co-secondary:hover { background:#e4e8ef; }
  .btn-co-success   { background:#22c55e; color:#fff; }
  .btn-co-success:hover   { background:#16a34a; }
  .btn-co-sm   { padding: 6px 12px; font-size: 12px; border-radius: 7px; }
  .btn-co-full { width: 100%; }

  /* â”€â”€â”€ Alerts â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
  .alert-co {
    padding: 12px 16px;
    border-radius: 10px;
    font-size: 13.5px;
    font-weight: 600;
    margin-bottom: 16px;
    display: flex;
    align-items: flex-start;
    gap: 10px;
  }
  .alert-co-success { background:#d1fae5; color:#065f46; border:1px solid #86efac; }
  .alert-co-error   { background:#fee2e2; color:#991b1b; border:1px solid #fca5a5; }

  /* â”€â”€â”€ Modal â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
  .modal-backdrop {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.55);
    z-index: 9999;
    align-items: center;
    justify-content: center;
    padding: 20px;
  }
  .modal-box {
    background: #fff;
    border-radius: 20px;
    width: 100%;
    max-width: 500px;
    box-shadow: 0 25px 50px rgba(0,0,0,.22);
    overflow: hidden;
  }
  .modal-head {
    padding: 16px 22px;
    border-bottom: 1px solid #e4e8ef;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #fafbfc;
  }
  .modal-head h3 { font-size: 15.5px; font-weight: 800; color: #0a1317; }
  .modal-close-btn {
    background: none; border: none; font-size: 20px; cursor: pointer;
    color: #5d6c7b; line-height: 1; padding: 2px 6px;
    border-radius: 6px; transition: background .15s;
  }
  .modal-close-btn:hover { background: #f1f4f7; }
  .modal-body { padding: 20px; }

  .form-grp { margin-bottom: 14px; }
  .form-grp label { display:block; font-size:13px; font-weight:600; color:#0a1317; margin-bottom:6px; }
  .form-grp input,
  .form-grp textarea {
    width: 100%; padding: 10px 14px;
    border: 1.5px solid #dee3e9; border-radius: 9px;
    font-size: 13.5px; font-family: inherit; color: #0a1317;
    background: #fff; transition: border-color .2s; outline: none;
  }
  .form-grp input:focus,
  .form-grp textarea:focus { border-color: #0064e0; }

  .preview-nota {
    background: #f9fafb; border: 1px solid #dee3e9;
    border-radius: 10px; padding: 14px; margin: 14px 0;
    font-size: 11.5px; line-height: 1.7; color: #374151;
  }
  .preview-nota .pn-title { font-weight: 800; font-size: 12.5px; color: #0a1317; margin-bottom: 6px; }

  /* â”€â”€â”€ Empty state â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
  .empty-state { text-align:center; padding:36px 20px; color:#8595a4; }
  .empty-state .es-icon { font-size:36px; margin-bottom:10px; }
  .empty-state p { font-size:13.5px; }
</style>
@endsection

@section('content')
@php
  $statusLabels = [
    'order'       => 'Order Baru',
    'on_progress' => 'Sedang Dikerjakan',
    'selesai'     => 'Selesai',
    'cancelled'   => 'Dibatalkan',
  ];
  $statusLabel = $statusLabels[$order->status] ?? $order->status;
  $progressPct = $orderTotal > 0 ? min(100, ($totalPaid / $orderTotal) * 100) : 0;
  $firstPayment = isset($allPayments) && count($allPayments) > 0 ? $allPayments[0] : null;

  $ps = $order->payment_status ?? null;
  $psLabel = match($ps) {
    'pending'  => ['label' => '⏳ Menunggu Verifikasi Admin', 'class' => 'chip-pending'],
    'verified' => ['label' => '✅ Bukti Terverifikasi',       'class' => 'chip-verified'],
    'rejected' => ['label' => '❌ Bukti Ditolak',             'class' => 'chip-rejected'],
    default    => ['label' => '📄 Belum Ada Bukti',           'class' => 'chip-none'],
  };
@endphp

<div class="co-wrap">

  {{-- Navbar --}}
  <nav class="co-nav">
    <a href="{{ route('customer.dashboard') }}" class="co-nav-brand">
      <div class="icon-box">K</div>
      Kafa Advertising
    </a>
    <a href="{{ route('customer.dashboard') }}" class="co-nav-back">← Dashboard</a>
  </nav>

  <div class="co-body">

    {{-- Flash messages --}}
    @if(session('success'))
      <div class="alert-co alert-co-success"><span>✅</span> {{ session('success') }}</div>
    @endif
    @if($errors->any())
      <div class="alert-co alert-co-error"><span>❌</span> {{ $errors->first() }}</div>
    @endif

    {{-- Hero Header --}}
    <div class="co-hero">
      <div>
        <div class="co-hero-title">Order #{{ $order->id }}</div>
        <div class="co-hero-sub">
          {{ $order->nama_pelanggan }}
          @if($order->no_hp) &nbsp;•&nbsp; {{ $order->no_hp }} @endif
          @if($order->kategori) &nbsp;•&nbsp; {{ $order->kategori }} @endif
        </div>
      </div>
      <div class="co-hero-right">
        <span class="co-status-badge {{ $isLunas ? 'badge-lunas' : 'badge-belum-lunas' }}">
          {{ $isLunas ? 'LUNAS' : 'BELUM LUNAS' }}
        </span>
        <div class="co-status-progress">
          Status Pengerjaan
          <strong>{{ $statusLabel }}</strong>
        </div>
      </div>
    </div>

    {{-- Two-column grid --}}
    <div class="co-grid">

      {{-- LEFT column --}}
      <div>

        {{-- Upload Nota --}}
        <div class="co-card">
          <div class="co-card-head">📤 Upload Bukti Pembayaran</div>
          <div class="co-card-body">

            <div class="pmt-status-chip {{ $psLabel['class'] }}">{{ $psLabel['label'] }}</div>

            @if($order->receipt_path)
              <div class="receipt-uploaded-box">
                <div class="ub-icon">✅</div>
                <div class="ub-info">
                  <strong>Bukti sudah diunggah</strong>
                  <span>Menunggu konfirmasi dari admin</span>
                </div>
                <a href="{{ $order->receipt_url }}" target="_blank"
                   class="btn-co btn-co-success btn-co-sm">Lihat</a>
              </div>
              <p style="font-size:12.5px;color:#5d6c7b;text-align:center;margin-bottom:14px;">
                Ingin mengganti? Unggah ulang di bawah.
              </p>
            @else
              <div class="receipt-preview-box">
                <div class="up-icon">🖼️</div>
                <p>Belum ada bukti pembayaran.<br>
                  <strong>Upload nota/struk</strong> untuk dikonfirmasi admin.</p>
              </div>
            @endif

            <form method="POST" action="{{ route('customer.payment.upload', $order->id) }}"
                  enctype="multipart/form-data">
              @csrf
              <span class="file-label-txt">
                {{ $order->receipt_path ? 'Ganti Bukti Pembayaran' : 'Pilih File Bukti' }}
              </span>
              <div class="file-input-wrap">
                <input type="file" name="bukti" accept="image/*" required>
                <div class="fi-icon">📎</div>
                <div class="fi-text">
                  <strong>Klik atau seret</strong> file ke sini<br>
                  <span style="font-size:11.5px;">JPEG, PNG, WebP — maks. 3 MB</span>
                </div>
              </div>
              <button type="submit" class="btn-co btn-co-primary btn-co-full" style="margin-top:14px;">
                📤 Unggah Nota Pembayaran
              </button>
            </form>

          </div>
        </div>

        {{-- Riwayat Pembayaran --}}
        <div class="co-card">
          <div class="co-card-head">🗂️ Riwayat Pembayaran</div>
          <div class="co-card-body">
            @forelse($allPayments as $pay)
              <div class="pay-item">
                <div style="flex:1;">
                  <div class="pay-badge-pill pay-badge-{{ $pay->metode }}">{{ strtoupper($pay->metode) }}</div>
                  <div class="pay-amount">Rp {{ number_format($pay->jumlah, 0, ',', '.') }}</div>
                  <div class="pay-date">{{ $pay->tanggal_bayar ? $pay->tanggal_bayar->format('d M Y, H:i') : '-' }}</div>
                  @if($pay->keterangan)
                    <div class="pay-note">{{ $pay->keterangan }}</div>
                  @endif
                </div>
                <div class="pay-actions">
                  <a href="{{ route('pembayaran.nota', $pay->id) }}" target="_blank"
                     class="btn-co btn-co-secondary btn-co-sm">🖨️ Nota</a>
                  @if($pay->bukti_url)
                    <a href="{{ $pay->bukti_url }}" target="_blank"
                       class="btn-co btn-co-secondary btn-co-sm">📷 Bukti</a>
                  @endif
                </div>
              </div>
            @empty
              <div class="empty-state">
                <div class="es-icon">💳</div>
                <p>Belum ada riwayat pembayaran.</p>
              </div>
            @endforelse
          </div>
        </div>

      </div>

      {{-- RIGHT column --}}
      <div class="co-sticky">
        <div class="co-card">
          <div class="co-card-head">📊 Ringkasan Tagihan</div>
          <div class="co-card-body">

            <div class="sum-row">
              <span class="sum-label">Total Tagihan</span>
              <span class="sum-val">Rp {{ number_format($orderTotal, 0, ',', '.') }}</span>
            </div>
            <div class="sum-row">
              <span class="sum-label">Sudah Dibayar</span>
              <span class="sum-val success">Rp {{ number_format($totalPaid, 0, ',', '.') }}</span>
            </div>
            <div class="sum-row">
              <span class="sum-label" style="font-weight:700;">Sisa Tagihan</span>
              <span class="sum-val danger" style="font-size:16px;">
                Rp {{ number_format($sisaTagihan, 0, ',', '.') }}
              </span>
            </div>

            <div class="prog-wrap">
              <div class="prog-labels">
                <span>Progress Pembayaran</span>
                <strong>{{ number_format($progressPct, 0) }}%</strong>
              </div>
              <div class="prog-bar">
                <div class="prog-fill" style="width:{{ $progressPct }}%;"></div>
              </div>
            </div>

            <div style="
              padding:11px 14px; border-radius:10px; font-size:13px; font-weight:600;
              margin-bottom:18px;
              background:{{ $isLunas ? '#d1fae5' : '#fef3c7' }};
              color:{{ $isLunas ? '#065f46' : '#92400e' }};
              border:1px solid {{ $isLunas ? '#86efac' : '#fcd34d' }};
            ">
              @if($isLunas)
                ✅ Order ini sudah <strong>LUNAS</strong>
              @elseif($totalPaid > 0)
                ⚠️ DP diterima — sisa Rp {{ number_format($sisaTagihan, 0, ',', '.') }}
              @else
                ℹ️ Belum ada pembayaran yang tercatat
              @endif
            </div>

            <div style="display:flex;flex-direction:column;gap:9px;">
              @if($firstPayment)
                <a href="{{ route('pembayaran.nota', $firstPayment->id) }}" target="_blank"
                   class="btn-co btn-co-secondary btn-co-full">
                  🖨️ Cetak Nota
                </a>
              @endif
              <button type="button"
                      class="btn-co btn-co-primary btn-co-full"
                      onclick="document.getElementById('sendWaModal').style.display='flex'">
                💬 Kirim Nota ke WhatsApp
              </button>
              <a href="{{ route('customer.dashboard') }}"
                 class="btn-co btn-co-secondary btn-co-full">
                ← Dashboard
              </a>
            </div>

          </div>
        </div>
      </div>

    </div><!-- /.co-grid -->
  </div><!-- /.co-body -->
</div><!-- /.co-wrap -->

{{-- Modal WhatsApp --}}
<div id="sendWaModal" class="modal-backdrop">
  <div class="modal-box">
    <div class="modal-head">
      <h3>💬 Kirim Nota ke WhatsApp</h3>
      <button class="modal-close-btn"
              onclick="document.getElementById('sendWaModal').style.display='none'">✕</button>
    </div>
    <div class="modal-body">
      <form method="POST" action="{{ route('customer.order.send.whatsapp', $order->id) }}">
        @csrf
        <div class="form-grp">
          <label>Nomor WhatsApp *</label>
          <input type="text" name="nomor_wa"
                 value="{{ old('nomor_wa', session('nomor_wa', $order->no_hp)) }}"
                 placeholder="cth. 081234567890" required>
        </div>
        <div class="form-grp">
          <label>Pesan Tambahan (opsional)</label>
          <textarea name="pesan_tambahan" rows="3"
                    placeholder="Tambahkan pesan untuk pelanggan...">{{ old('pesan_tambahan') }}</textarea>
        </div>

        <div class="preview-nota">
          <div class="pn-title">📋 Preview Pesan</div>
          *NOTA PEMBAYARAN ORDER #{{ $order->id }}*<br>
          ━━━━━━━━━━━━━━━━━━━━<br>
          Nama: {{ $order->nama_pelanggan }}<br>
          Total: Rp {{ number_format($orderTotal, 0, ',', '.') }}<br>
          Dibayar: Rp {{ number_format($totalPaid, 0, ',', '.') }}<br>
          Sisa: Rp {{ number_format($sisaTagihan, 0, ',', '.') }}<br>
          Status: {{ $isLunas ? 'LUNAS ✅' : 'BELUM LUNAS ⚠️' }}<br>
          Progress: {{ $statusLabel }}
        </div>

        @if(session('wa_url'))
          <div style="text-align:center;padding:12px;background:#d1fae5;border-radius:10px;margin-bottom:14px;">
            <div style="font-size:13px;font-weight:700;color:#065f46;margin-bottom:8px;">Nota berhasil disiapkan!</div>
            <a href="{{ session('wa_url') }}" target="_blank"
               class="btn-co btn-co-success btn-co-full">💬 Buka WhatsApp Sekarang</a>
          </div>
        @endif

        <div style="display:flex;gap:10px;margin-top:4px;">
          <button type="button" class="btn-co btn-co-secondary" style="flex:1;"
                  onclick="document.getElementById('sendWaModal').style.display='none'">Batal</button>
          <button type="submit" class="btn-co btn-co-primary" style="flex:1;">💬 Kirim</button>
        </div>
      </form>
    </div>
  </div>
</div>

@if(session('success') && session('wa_url'))
<script>
  document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('sendWaModal').style.display = 'flex';
  });
</script>
@endif
@endsection
