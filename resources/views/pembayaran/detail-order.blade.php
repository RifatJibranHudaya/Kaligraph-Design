@extends('layouts.app')

@section('title', 'Detail Pembayaran Order #' . $order->id)

@section('styles')
<style>
  /* ─── Ticketing System Layout ─── */
  .ticket-breadcrumb {
    font-size: 13px;
    color: var(--text-muted);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .ticket-breadcrumb a {
    color: var(--primary);
    text-decoration: none;
    font-weight: 600;
  }

  .ticket-breadcrumb a:hover {
    text-decoration: underline;
  }

  .ticket-breadcrumb .separator {
    color: var(--text-muted);
  }

  .ticket-breadcrumb .current {
    color: var(--text-main);
    font-weight: 700;
  }

  .ticket-page-title {
    font-size: 22px;
    font-weight: 800;
    color: var(--text-main);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  /* Action Bar */
  .ticket-action-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 24px;
    padding: 16px 20px;
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: var(--radius);
    box-shadow: var(--shadow-sm);
  }

  .ticket-action-left {
    display: flex;
    gap: 10px;
    align-items: center;
  }

  .ticket-action-right {
    display: flex;
    gap: 10px;
    align-items: center;
    flex-wrap: wrap;
  }

  .btn-back {
    background: var(--primary);
    color: #fff;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 700;
    padding: 8px 16px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
    transition: all 0.2s;
    border: none;
    cursor: pointer;
  }

  .btn-back:hover {
    background: var(--primary-hover);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
  }

  .btn-action-add {
    background: linear-gradient(135deg, #10b981, #059669);
    color: #fff;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 700;
    padding: 8px 16px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
    transition: all 0.2s;
    border: none;
    cursor: pointer;
  }

  .btn-action-add:hover {
    background: linear-gradient(135deg, #059669, #047857);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
  }

  .btn-action-print {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: #fff;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 700;
    padding: 8px 16px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
    transition: all 0.2s;
    border: none;
    cursor: pointer;
  }

  .btn-action-print:hover {
    background: linear-gradient(135deg, #d97706, #b45309);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
  }

  .btn-action-wa {
    background: linear-gradient(135deg, #25D366, #128C7E);
    color: #fff;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 700;
    padding: 8px 16px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
    transition: all 0.2s;
    border: none;
    cursor: pointer;
  }

  .btn-action-wa:hover {
    background: linear-gradient(135deg, #128C7E, #075E54);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
  }

  /* ─── Ticket Info Section ─── */
  .ticket-section {
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: var(--radius);
    padding: 24px;
    margin-bottom: 24px;
    box-shadow: var(--shadow-sm);
  }

  .ticket-section-title {
    font-size: 17px;
    font-weight: 800;
    color: var(--text-main);
    margin-bottom: 18px;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  /* Info Table (ticket detail rows) */
  .ticket-info-table {
    width: 100%;
    border-collapse: collapse;
  }

  .ticket-info-table tr {
    border-bottom: 1px solid var(--border-color);
  }

  .ticket-info-table tr:last-child {
    border-bottom: none;
  }

  .ticket-info-table th {
    text-align: left;
    padding: 12px 16px;
    font-size: 14px;
    font-weight: 700;
    color: var(--text-main);
    width: 180px;
    vertical-align: top;
    white-space: nowrap;
  }

  .ticket-info-table td {
    padding: 12px 16px;
    font-size: 14px;
    color: var(--text-main);
  }

  /* ─── Keterangan Section (blue left border) ─── */
  .ticket-keterangan {
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: var(--radius);
    padding: 24px;
    margin-bottom: 24px;
    box-shadow: var(--shadow-sm);
  }

  .keterangan-block {
    border-left: 4px solid var(--primary);
    background: var(--primary-light);
    border-radius: 0 8px 8px 0;
    padding: 14px 18px;
    font-size: 14px;
    color: var(--text-main);
    line-height: 1.6;
  }

  /* ─── Ringkasan Section (amber left border) ─── */
  .ringkasan-block {
    border-left: 4px solid var(--warning);
    background: #fef3c7;
    border-radius: 0 8px 8px 0;
    padding: 14px 18px;
    font-size: 14px;
    color: #92400e;
    line-height: 1.6;
  }

  [data-theme="dark"] .ringkasan-block {
    background: rgba(245, 158, 11, 0.1);
    color: #fbbf24;
  }

  .ringkasan-grid {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 16px;
    margin-bottom: 16px;
  }

  .ringkasan-item {
    text-align: center;
  }

  .ringkasan-item .label {
    font-size: 12px;
    font-weight: 600;
    color: var(--text-muted);
    margin-bottom: 4px;
  }

  .ringkasan-item .value {
    font-size: 18px;
    font-weight: 800;
  }

  .ringkasan-item .value.total {
    color: var(--text-main);
  }

  .ringkasan-item .value.paid {
    color: var(--success);
  }

  .ringkasan-item .value.remaining {
    color: var(--danger);
  }

  /* Progress bar */
  .progress-container {
    background: #e5e7eb;
    border-radius: 10px;
    height: 14px;
    overflow: hidden;
    position: relative;
  }

  [data-theme="dark"] .progress-container {
    background: #334155;
  }

  .progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #10b981, #34d399);
    border-radius: 10px;
    transition: width 0.6s ease;
    position: relative;
  }

  .progress-fill.complete {
    background: linear-gradient(90deg, #10b981, #6ee7b7);
  }

  .progress-text {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 12px;
    margin-top: 6px;
  }

  /* ─── Riwayat Section with metric badges ─── */
  .riwayat-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 18px;
  }

  .metric-badges {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
  }

  .metric-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    white-space: nowrap;
  }

  .metric-badge.total-badge {
    background: #dbeafe;
    color: #1e40af;
    border: 1px solid #bfdbfe;
  }

  .metric-badge.paid-badge {
    background: #d1fae5;
    color: #065f46;
    border: 1px solid #a7f3d0;
  }

  .metric-badge.sisa-badge {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #fecaca;
  }

  .metric-badge.status-badge-lunas {
    background: #d1fae5;
    color: #065f46;
    border: 1px solid #a7f3d0;
  }

  .metric-badge.status-badge-belum {
    background: #fef3c7;
    color: #92400e;
    border: 1px solid #fde68a;
  }

  .metric-badge .count {
    font-size: 11px;
    font-weight: 600;
    opacity: 0.8;
  }

  /* Riwayat table action buttons */
  .riwayat-actions {
    display: flex;
    gap: 6px;
    align-items: center;
  }

  .riwayat-actions .btn-icon {
    width: 30px;
    height: 30px;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    border: 1px solid var(--border-color);
    background: var(--bg-main);
    color: var(--text-muted);
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
  }

  .riwayat-actions .btn-icon:hover {
    border-color: var(--primary);
    color: var(--primary);
    background: var(--primary-light);
  }

  .riwayat-actions .btn-icon.danger:hover {
    border-color: var(--danger);
    color: var(--danger);
    background: #fee2e2;
  }

  /* ─── Modal Styles ─── */
  .ticket-modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(4px);
    z-index: 9999;
    align-items: center;
    justify-content: center;
    padding: 20px;
    animation: fadeIn 0.2s ease;
  }

  .ticket-modal-overlay.active {
    display: flex;
  }

  @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }

  @keyframes slideUp {
    from { transform: translateY(20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
  }

  .ticket-modal {
    width: 100%;
    max-width: 560px;
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 16px;
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3);
    animation: slideUp 0.3s ease;
    max-height: 85vh;
    display: flex;
    flex-direction: column;
    overflow: hidden;
  }

  .ticket-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 20px;
    border-bottom: 1px solid var(--border-color);
    flex-shrink: 0;
  }

  .ticket-modal-header h3 {
    font-size: 16px;
    font-weight: 800;
    color: var(--text-main);
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .ticket-modal-close {
    width: 30px;
    height: 30px;
    border-radius: 8px;
    border: 1px solid var(--border-color);
    background: var(--bg-main);
    color: var(--text-muted);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    cursor: pointer;
    transition: all 0.2s;
  }

  .ticket-modal-close:hover {
    background: var(--danger);
    color: #fff;
    border-color: var(--danger);
  }

  .ticket-modal-body {
    padding: 20px;
    overflow-y: auto;
    max-height: calc(85vh - 70px);
  }

  /* Status badge inside info table */
  .status-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
  }

  .status-pill.order { background: #dbeafe; color: #1e40af; }
  .status-pill.on_progress { background: #fef3c7; color: #92400e; }
  .status-pill.selesai { background: #d1fae5; color: #065f46; }
  .status-pill.cancelled { background: #fee2e2; color: #991b1b; }
  .status-pill.lunas { background: #d1fae5; color: #065f46; }
  .status-pill.belum { background: #fef3c7; color: #92400e; }

  /* WA Button */
  .wa-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 12px 24px;
    background: #25D366;
    color: #ffffff;
    font-weight: 700;
    font-size: 14px;
    border-radius: 10px;
    text-decoration: none;
    transition: all 0.2s;
    border: none;
    cursor: pointer;
    width: 100%;
  }

  .wa-button:hover {
    background: #128C7E;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(37, 211, 102, 0.35);
  }

  /* Bukti popup */
  .bukti-thumb {
    width: 36px;
    height: 36px;
    border-radius: 6px;
    object-fit: cover;
    cursor: pointer;
    border: 1px solid var(--border-color);
    transition: all 0.2s;
  }

  .bukti-thumb:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  }

  /* Responsive */
  @media (max-width: 768px) {
    .ticket-section, .ticket-keterangan {
      padding: 14px 12px;
      margin-bottom: 14px;
      border-radius: var(--radius-xl);
    }
    .ticket-section-title {
      font-size: 15px;
      margin-bottom: 12px;
    }
    .ticket-info-table th {
      width: 95px;
      padding: 8px 6px;
      font-size: 12px;
      white-space: normal;
    }
    .ticket-info-table td {
      padding: 8px 6px;
      font-size: 12px;
      word-break: break-word;
    }
    .ringkasan-grid {
      grid-template-columns: repeat(3, 1fr);
      gap: 6px;
    }
    .ringkasan-item .label {
      font-size: 10.5px;
      margin-bottom: 2px;
    }
    .ringkasan-item .value {
      font-size: 13.5px;
      word-break: break-word;
    }
    .ticket-action-bar {
      padding: 10px 12px;
      gap: 8px;
      border-radius: var(--radius-xl);
    }
    .ticket-action-left, .ticket-action-right {
      width: 100%;
      display: flex;
      gap: 6px;
    }
    .ticket-action-left .btn-back,
    .ticket-action-right .btn-action-add,
    .ticket-action-right .btn-action-print,
    .ticket-action-right .btn-action-wa {
      flex: 1;
      padding: 8px 8px;
      font-size: 11.5px;
      justify-content: center;
      text-align: center;
    }
    .metric-badges {
      gap: 4px;
      justify-content: flex-start;
      margin-top: 6px;
    }
    .metric-badge {
      padding: 3px 8px;
      font-size: 10.5px;
    }
  }
</style>
@endsection

@section('content')
{{-- Breadcrumb --}}
<div class="ticket-breadcrumb">
  <a href="{{ route('dashboard') }}">Dashboard</a>
  <span class="separator">/</span>
  <a href="{{ route('status_order.index') }}">Status Pengerjaan</a>
  <span class="separator">/</span>
  <span class="current">Detail Order #{{ $order->id }}</span>
</div>

{{-- Page Title --}}
<h2 class="ticket-page-title">
  Detail Order & Pembayaran #{{ $order->id }}
</h2>

{{-- Flash Messages --}}
@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
  <div class="alert alert-error">{{ session('error') }}</div>
@endif

{{-- Action Bar --}}
<div class="ticket-action-bar">
  <div class="ticket-action-left">
    <a href="{{ route('status_order.index') }}" class="btn-back">
      ← Kembali
    </a>
  </div>
  <div class="ticket-action-right">
    @if(!$isLunas)
    <button type="button" class="btn-action-add" onclick="openModal('catatBayarModal')">
      + Bayar
    </button>
    @endif
    @php $firstPayment = $allPayments && count($allPayments) > 0 ? $allPayments[0] : null; @endphp
    @if($firstPayment)
    <a href="{{ route('pembayaran.nota', $firstPayment->id) }}" target="_blank" class="btn-action-print">
      Cetak
    </a>
    @endif
    <button type="button" class="btn-action-wa" onclick="openModal('sendWaModal')">
      WhatsApp
    </button>
  </div>
</div>

{{-- Info Ticket Section --}}
<div class="ticket-section">
  <div class="ticket-section-title">
    Info Order #{{ $order->id }}
  </div>
  <table class="ticket-info-table">
    <tr>
      <th>Tgl Order</th>
      <td>{{ $order->created_at ? $order->created_at->format('d-m-Y H:i') : '-' }}</td>
    </tr>
    <tr>
      <th>Pelanggan</th>
      <td><strong>{{ $order->nama_pelanggan }}</strong></td>
    </tr>
    <tr>
      <th>No. HP</th>
      <td>{{ $order->no_hp ?: '-' }}</td>
    </tr>
    <tr>
      <th>Kategori</th>
      <td>{{ $order->kategori ?: '-' }}</td>
    </tr>
    <tr>
      <th>Alamat</th>
      <td>{{ $order->alamat ?: '-' }}</td>
    </tr>
    <tr>
      <th>Cabang</th>
      <td>{{ $order->branch ? $order->branch->name : '-' }}</td>
    </tr>
    <tr>
      <th>Status Order</th>
      <td>
        @php
          $statusClasses = [
            'order' => 'order',
            'on_progress' => 'on_progress',
            'selesai' => 'selesai',
            'cancelled' => 'cancelled',
          ];
          $statusLabels = [
            'order' => 'Order Baru',
            'on_progress' => 'On Progress',
            'selesai' => 'Selesai',
            'cancelled' => 'Cancelled',
          ];
          $statusClass = $statusClasses[$order->status] ?? 'order';
          $statusLabel = $statusLabels[$order->status] ?? ucfirst($order->status);
        @endphp
        <span class="status-pill {{ $statusClass }}">{{ $statusLabel }}</span>
      </td>
    </tr>
    <tr>
      <th>Status Bayar</th>
      <td>
        <span class="status-pill {{ $isLunas ? 'lunas' : 'belum' }}">
          {{ $isLunas ? 'Lunas' : 'Belum Lunas' }}
        </span>
      </td>
    </tr>
  </table>
</div>

{{-- Keterangan Section --}}
<div class="ticket-keterangan">
  <div class="ticket-section-title">
    Keterangan
  </div>
  <div class="keterangan-block">
    {{ $order->keterangan ?: 'Tidak ada keterangan untuk order ini.' }}
  </div>
</div>

{{-- Ringkasan Pembayaran Section --}}
<div class="ticket-section">
  <div class="ticket-section-title">
    Ringkasan Pembayaran
  </div>

  <div class="ringkasan-block" style="margin-bottom: 20px;">
    <div class="ringkasan-grid">
      <div class="ringkasan-item">
        <div class="label">Total</div>
        <div class="value total">Rp {{ number_format($orderTotal, 0, ',', '.') }}</div>
      </div>
      <div class="ringkasan-item">
        <div class="label">Dibayar</div>
        <div class="value paid">Rp {{ number_format($totalPaid, 0, ',', '.') }}</div>
      </div>
      <div class="ringkasan-item">
        <div class="label">Sisa</div>
        <div class="value remaining">Rp {{ number_format($sisaTagihan, 0, ',', '.') }}</div>
      </div>
    </div>

    {{-- Progress Bar --}}
    @php
      $progressPercent = $orderTotal > 0 ? min(100, ($totalPaid / $orderTotal) * 100) : 0;
    @endphp
    <div class="progress-container">
      <div class="progress-fill {{ $isLunas ? 'complete' : '' }}" style="width: {{ $progressPercent }}%;"></div>
    </div>
    <div class="progress-text">
      <span style="color: var(--text-muted);">Progress Bayar</span>
      <span style="font-weight: 700; color: {{ $isLunas ? 'var(--success)' : 'var(--primary)' }};">{{ number_format($progressPercent, 0) }}%</span>
    </div>
  </div>

  {{-- Status Info Block --}}
  <div style="background: {{ $isLunas ? '#d1fae5' : ($totalPaid > 0 ? '#fef3c7' : '#fee2e2') }}; border-radius: 10px; padding: 12px 16px; text-align: center;">
    <span style="font-size: 13.5px; font-weight: 700; color: {{ $isLunas ? '#065f46' : ($totalPaid > 0 ? '#92400e' : '#991b1b') }};">
      @if($isLunas)
        Order ini sudah LUNAS
      @elseif($totalPaid > 0)
        DP diterima, sisa Rp {{ number_format($sisaTagihan, 0, ',', '.') }}
      @else
        Belum ada pembayaran
      @endif
    </span>
  </div>
</div>

{{-- Riwayat Pembayaran Section --}}
<div class="ticket-section">
  <div class="riwayat-header">
    <div class="ticket-section-title" style="margin-bottom: 0;">
      Riwayat Pembayaran
    </div>

    <div class="metric-badges">
      <span class="metric-badge total-badge">
        Tot: Rp {{ number_format($orderTotal, 0, ',', '.') }}
      </span>
      <span class="metric-badge paid-badge">
        Bayar: Rp {{ number_format($totalPaid, 0, ',', '.') }}
      </span>
      @if(!$isLunas)
      <span class="metric-badge sisa-badge">
        Sisa: Rp {{ number_format($sisaTagihan, 0, ',', '.') }}
      </span>
      @endif
      <span class="metric-badge {{ $isLunas ? 'status-badge-lunas' : 'status-badge-belum' }}">
        {{ $isLunas ? 'Lunas' : 'Belum' }}
      </span>
      <span class="metric-badge total-badge">
        {{ count($allPayments) }} entri
      </span>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table" id="riwayatTable">
      <thead>
        <tr>
          <th>No</th>
          <th>Tanggal</th>
          <th>Metode</th>
          <th>Jumlah</th>
          <th>Keterangan</th>
          <th>Bukti</th>
          <th>Dicatat Oleh</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($allPayments as $index => $pay)
          <tr>
            <td>
              <a href="{{ route('pembayaran.nota', $pay->id) }}" target="_blank" style="color: var(--primary); font-weight: 700; text-decoration: none;">
                {{ $index + 1 }}
              </a>
            </td>
            <td>{{ $pay->tanggal_bayar ? $pay->tanggal_bayar->format('d-m-Y') : '-' }}</td>
            <td>
              <span class="badge {{ $pay->metode === 'dp' ? 'badge-warning' : ($pay->metode === 'transfer' ? 'badge-primary' : 'badge-success') }}">
                {{ strtoupper($pay->metode) }}
              </span>
            </td>
            <td>
              <strong style="color: var(--success);">
                Rp {{ number_format($pay->jumlah, 0, ',', '.') }}
              </strong>
            </td>
            <td>
              <span style="font-size: 13px; color: var(--text-muted);">
                {{ $pay->keterangan ? Str::limit($pay->keterangan, 40) : '-' }}
              </span>
            </td>
            <td>
              @if($pay->bukti_url)
                <img src="{{ $pay->bukti_url }}" alt="Bukti" class="bukti-thumb" onclick="window.open('{{ $pay->bukti_url }}', '_blank')">
              @else
                <span style="color: var(--text-muted); font-size: 12px;">—</span>
              @endif
            </td>
            <td>
              <span style="font-size: 13px;">{{ $pay->user ? $pay->user->username : '-' }}</span>
            </td>
            <td>
              <div class="riwayat-actions">
                <a href="{{ route('pembayaran.nota', $pay->id) }}" target="_blank" class="btn-icon" title="Lihat Nota">
                  Lihat
                </a>
                <form method="POST" action="{{ route('pembayaran.destroy', $pay->id) }}" onsubmit="return confirm('Hapus data pembayaran ini?')" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn-icon danger" title="Hapus Pembayaran">
                    🗑️
                  </button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="8" style="text-align: center; color: var(--text-muted); padding: 40px;">
              
              Belum ada pembayaran yang tercatat untuk order ini.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

{{-- ═══════════════════════════════════════════════ --}}
{{-- MODAL: Catat Pembayaran Baru                   --}}
{{-- ═══════════════════════════════════════════════ --}}
<div id="catatBayarModal" class="ticket-modal-overlay">
  <div class="ticket-modal">
    <div class="ticket-modal-header">
      <h3>Catat Pembayaran Baru</h3>
      <button type="button" class="ticket-modal-close" onclick="closeModal('catatBayarModal')">✕</button>
    </div>
    <div class="ticket-modal-body">
      <form method="POST" action="{{ route('pembayaran.store') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="order_id" value="{{ $order->id }}">
        <input type="hidden" name="redirect_to_detail" value="1">

        <div class="grid grid-2">
          <div class="form-group">
            <label class="form-label" style="display:flex; justify-content:space-between; align-items:center;">
              <span>Jumlah Pembayaran (Rp) *</span>
              <span style="font-size:11px; color:var(--primary); font-weight:700;">
                Maks: Rp {{ number_format($sisaTagihan, 0, ',', '.') }}
              </span>
            </label>
            <div style="position:relative;">
              <input type="text" 
                     id="input_jumlah_display" 
                     class="form-control" 
                     placeholder="cth. 500.000" 
                     value="{{ old('jumlah') ? number_format((int)old('jumlah'), 0, ',', '.') : '' }}" 
                     autocomplete="off" 
                     required>
              <input type="hidden" name="jumlah" id="input_jumlah_raw" value="{{ old('jumlah') }}">
            </div>
            <div id="jumlah_warning" style="display:none; font-size:11.5px; color:var(--danger); margin-top:4px; font-weight:600;"></div>
            <div style="margin-top:6px; display:flex; gap:6px; flex-wrap:wrap;">
              <button type="button" class="btn btn-sm btn-secondary" onclick="setPaymentAmount({{ $sisaTagihan }})" style="font-size:11px; padding:3px 10px; border-radius:100px;">
                Bayar Lunas (Rp {{ number_format($sisaTagihan, 0, ',', '.') }})
              </button>
              @if($sisaTagihan > 100000 && $totalPaid == 0)
              <button type="button" class="btn btn-sm btn-secondary" onclick="setPaymentAmount({{ round($orderTotal * 0.5) }})" style="font-size:11px; padding:3px 10px; border-radius:100px;">
                DP 50% (Rp {{ number_format(round($orderTotal * 0.5), 0, ',', '.') }})
              </button>
              @endif
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">Metode Pembayaran *</label>
            <select name="metode" class="form-control" required>
              <option value="transfer" {{ old('metode') === 'transfer' ? 'selected' : '' }}>Transfer Bank / QRIS</option>
              <option value="cash" {{ old('metode') === 'cash' ? 'selected' : '' }}>Tunai / Cash</option>
              <option value="dp" {{ old('metode') === 'dp' ? 'selected' : '' }}>Uang Muka (DP)</option>
            </select>
          </div>
        </div>

        <div class="grid grid-2">
          <div class="form-group">
            <label class="form-label">Tanggal Bayar *</label>
            <input type="date" name="tanggal_bayar" class="form-control" value="{{ old('tanggal_bayar', date('Y-m-d')) }}" required>
          </div>
          <div class="form-group">
            <label class="form-label">Bukti Transfer (Opsional)</label>
            <input type="file" name="bukti" class="form-control" accept="image/*">
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Catatan / Keterangan</label>
          <textarea name="keterangan" class="form-control" rows="2" placeholder="cth. DP 50% awal via BCA, pelunasan saat selesai...">{{ old('keterangan') }}</textarea>
        </div>

        {{-- Quick info --}}
        <div style="background: var(--bg-main); border: 1px solid var(--border-color); border-radius: 10px; padding: 12px 16px; margin-bottom: 16px;">
          <div style="font-size: 12px; font-weight: 700; color: var(--text-muted); margin-bottom: 6px;">INFO ORDER</div>
          <div style="display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 4px;">
            <span>Total Tagihan</span>
            <strong>Rp {{ number_format($orderTotal, 0, ',', '.') }}</strong>
          </div>
          <div style="display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 4px;">
            <span>Sudah Dibayar</span>
            <strong style="color: var(--success);">Rp {{ number_format($totalPaid, 0, ',', '.') }}</strong>
          </div>
          <div style="display: flex; justify-content: space-between; font-size: 13px; padding-top: 6px; border-top: 1px solid var(--border-color);">
            <span>Sisa Tagihan</span>
            <strong style="color: var(--danger);">Rp {{ number_format($sisaTagihan, 0, ',', '.') }}</strong>
          </div>
        </div>

        <div style="display: flex; gap: 10px;">
          <button type="button" class="btn btn-secondary" onclick="closeModal('catatBayarModal')" style="flex: 1;">Batal</button>
          <button type="submit" class="btn btn-primary" style="flex: 1;">Simpan Pembayaran</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- ═══════════════════════════════════════════════ --}}
{{-- MODAL: Kirim WhatsApp                          --}}
{{-- ═══════════════════════════════════════════════ --}}
<div id="sendWaModal" class="ticket-modal-overlay">
  <div class="ticket-modal">
    <div class="ticket-modal-header">
      <h3>Kirim Nota ke WhatsApp</h3>
      <button type="button" class="ticket-modal-close" onclick="closeModal('sendWaModal')">✕</button>
    </div>
    <div class="ticket-modal-body">
      <form method="POST" action="{{ route('pembayaran.send.whatsapp', $order->id) }}">
        @csrf
        <div class="form-group">
          <label class="form-label">Nomor WhatsApp Pelanggan *</label>
          <input type="text" name="nomor_wa" class="form-control" value="{{ old('nomor_wa', session('nomor_wa', $order->no_hp)) }}" placeholder="cth. 081234567890" required>
          <small style="color: var(--text-muted); font-size: 12px; display: block; margin-top: 4px;">
            Nomor akan otomatis diformat ke standar WhatsApp.
          </small>
        </div>

        <div class="form-group">
          <label class="form-label">Pesan Tambahan (Opsional)</label>
          <textarea name="pesan_tambahan" class="form-control" rows="3" placeholder="Tambahkan pesan pribadi untuk pelanggan...">{{ old('pesan_tambahan') }}</textarea>
        </div>

        {{-- Preview Nota --}}
        <div style="background: var(--bg-main); border: 1px solid var(--border-color); border-radius: 10px; padding: 12px; margin-bottom: 16px;">
          <div style="font-size: 12px; font-weight: 700; color: var(--text-muted); margin-bottom: 8px;">PREVIEW PESAN:</div>
          <div style="font-size: 11px; line-height: 1.6; color: var(--text-main);">
            *NOTA PEMBAYARAN ORDER #{{ $order->id }}*<br>
            ━━━━━━━━━━━━━━━━━━━━<br>
            *Detail Order*<br>
            Nama: {{ $order->nama_pelanggan }}<br>
            Total: Rp {{ number_format($orderTotal, 0, ',', '.') }}<br>
            Dibayar: Rp {{ number_format($totalPaid, 0, ',', '.') }}<br>
            Sisa: Rp {{ number_format($sisaTagihan, 0, ',', '.') }}<br>
            Status: {{ $isLunas ? 'LUNAS' : 'BELUM LUNAS' }}<br>
            Progress: {{ $statusLabel }}
          </div>
        </div>

        @if(session('wa_url'))
          <div style="margin-bottom: 16px; padding: 12px; background: #d1fae5; border-radius: 10px; text-align: center;">
            <div style="font-size: 13px; font-weight: 700; color: #065f46; margin-bottom: 8px;">
              Nota berhasil disiapkan!
            </div>
            <a href="{{ session('wa_url') }}" target="_blank" class="wa-button" style="padding: 10px 20px; font-size: 14px;">
              💬 Buka WhatsApp Sekarang
            </a>
          </div>
        @endif

        <div style="display: flex; gap: 10px;">
          <button type="button" class="btn btn-secondary" onclick="closeModal('sendWaModal')" style="flex: 1;">Batal</button>
          <button type="submit" class="btn btn-primary" style="flex: 1;">💬 Kirim ke WhatsApp</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  // ─── Modal Controls ───
  function openModal(id) {
    document.getElementById(id).classList.add('active');
    document.body.style.overflow = 'hidden';
  }

  function closeModal(id) {
    document.getElementById(id).classList.remove('active');
    document.body.style.overflow = '';
  }

  // Close modal on overlay click
  document.querySelectorAll('.ticket-modal-overlay').forEach(function(overlay) {
    overlay.addEventListener('click', function(e) {
      if (e.target === overlay) {
        overlay.classList.remove('active');
        document.body.style.overflow = '';
      }
    });
  });

  // Close modal on Escape key
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      document.querySelectorAll('.ticket-modal-overlay.active').forEach(function(modal) {
        modal.classList.remove('active');
      });
      document.body.style.overflow = '';
    }
  });

  // Auto-open WA modal if redirect with wa_url
  @if(session('success') && session('wa_url'))
    document.addEventListener('DOMContentLoaded', function() {
      openModal('sendWaModal');
    });
  @endif

  // Auto-open payment modal if there are validation errors
  @if($errors->any())
    document.addEventListener('DOMContentLoaded', function() {
      openModal('catatBayarModal');
    });
  @endif

  // ─── Payment Amount Formatter & Limit Enforcer ───
  const maxBayar = {{ (int) $sisaTagihan }};
  const inputDisplay = document.getElementById('input_jumlah_display');
  const inputRaw = document.getElementById('input_jumlah_raw');
  const warningEl = document.getElementById('jumlah_warning');

  function formatRupiahDisplay(val) {
    let raw = String(val).replace(/\D/g, '');
    if (!raw) return '';
    return raw.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
  }

  function setPaymentAmount(amount) {
    let clean = Math.min(amount, maxBayar);
    if (inputDisplay && inputRaw) {
      inputRaw.value = clean;
      inputDisplay.value = formatRupiahDisplay(clean);
      checkLimit(clean);
    }
  }

  function checkLimit(valNum) {
    if (!warningEl || !inputDisplay) return;
    if (valNum > maxBayar) {
      warningEl.textContent = 'Nominal tidak boleh melebihi sisa tagihan (Maks: Rp ' + formatRupiahDisplay(maxBayar) + ')';
      warningEl.style.display = 'block';
      inputDisplay.style.borderColor = 'var(--danger)';
    } else {
      warningEl.style.display = 'none';
      inputDisplay.style.borderColor = '';
    }
  }

  if (inputDisplay && inputRaw) {
    inputDisplay.addEventListener('input', function() {
      let rawDigits = this.value.replace(/\D/g, '');
      let numVal = parseInt(rawDigits, 10) || 0;

      if (numVal > maxBayar) {
        numVal = maxBayar;
        rawDigits = String(maxBayar);
      }

      inputRaw.value = rawDigits;
      this.value = formatRupiahDisplay(rawDigits);
      checkLimit(numVal);
    });

    // Ensure raw value is populated before submit
    const payForm = inputDisplay.closest('form');
    if (payForm) {
      payForm.addEventListener('submit', function(e) {
        let rawDigits = inputDisplay.value.replace(/\D/g, '');
        let numVal = parseInt(rawDigits, 10) || 0;
        if (numVal > maxBayar) {
          e.preventDefault();
          checkLimit(numVal);
          return false;
        }
        inputRaw.value = rawDigits;
      });
    }
  }
</script>

@endsection
