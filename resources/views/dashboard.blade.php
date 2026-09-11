@extends('layouts.app')

@section('title', 'Dashboard Analytics')

@section('content')
<!-- Metric Cards -->
<div class="grid grid-4" style="margin-bottom: 24px;">
  <div class="card" style="margin-bottom:0;">
    <div style="display:flex; justify-content:space-between; align-items:center;">
      <div>
        <div style="font-size:13px; font-weight:600; color:var(--text-muted);">Total Pesanan Masuk</div>
        <div style="font-size:24px; font-weight:800; color:var(--primary); margin-top:6px;">
          {{ number_format($totalOrders, 0, ',', '.') }}
        </div>
      </div>
      <div style="width:48px; height:48px; border-radius:12px; background:#dbeafe; display:flex; align-items:center; justify-content:center; font-size:24px;">
      </div>
    </div>
  </div>

  <div class="card" style="margin-bottom:0;">
    <div style="display:flex; justify-content:space-between; align-items:center;">
      <div>
        <div style="font-size:13px; font-weight:600; color:var(--text-muted);">Total Pembayaran Diterima</div>
        <div style="font-size:24px; font-weight:800; color:var(--success); margin-top:6px;">
          Rp {{ number_format($totalPembayaran, 0, ',', '.') }}
        </div>
      </div>
      <div style="width:48px; height:48px; border-radius:12px; background:#d1fae5; display:flex; align-items:center; justify-content:center; font-size:24px;">
      </div>
    </div>
  </div>

  <div class="card" style="margin-bottom:0;">
    <div style="display:flex; justify-content:space-between; align-items:center;">
      <div>
        <div style="font-size:13px; font-weight:600; color:var(--text-muted);">Kategori Layanan</div>
        <div style="font-size:24px; font-weight:800; color:var(--purple); margin-top:6px;">
          {{ $totalCategories }}
        </div>
      </div>
      <div style="width:48px; height:48px; border-radius:12px; background:#ede9fe; display:flex; align-items:center; justify-content:center; font-size:24px;">
      </div>
    </div>
  </div>

  <div class="card" style="margin-bottom:0;">
    <div style="display:flex; justify-content:space-between; align-items:center;">
      <div>
        <div style="font-size:13px; font-weight:600; color:var(--text-muted);">Katalog Produk Aktif</div>
        <div style="font-size:24px; font-weight:800; color:var(--accent); margin-top:6px;">
          {{ $totalProducts }}
        </div>
      </div>
      <div style="width:48px; height:48px; border-radius:12px; background:#e0f2fe; display:flex; align-items:center; justify-content:center; font-size:24px;">
      </div>
    </div>
  </div>
</div>

<!-- Order Status Overview Progress Bar -->
<div class="card" style="margin-bottom:24px;">
  <div class="card-header">
    <h3 class="card-title">Status Alur Pengerjaan Pesanan</h3>
    <a href="{{ route('status_order.index') }}" class="btn btn-sm btn-secondary">Kelola Status ➔</a>
  </div>
  <div class="grid grid-4" style="gap:16px;">
    <div style="background:#fef3c7; border:1px solid #fde68a; border-radius:12px; padding:16px;">
      <div style="font-size:12px; font-weight:700; color:#92400e;">ORDER BARU</div>
      <div style="font-size:22px; font-weight:800; color:#92400e; margin-top:4px;">{{ $ordersOrder }}</div>
      <div style="font-size:11px; color:#b45309; margin-top:2px;">Menunggu konfirmasi / DP</div>
    </div>
    <div style="background:#dbeafe; border:1px solid #bfdbfe; border-radius:12px; padding:16px;">
      <div style="font-size:12px; font-weight:700; color:#1e40af;">ON PROGRESS</div>
      <div style="font-size:22px; font-weight:800; color:#1e40af; margin-top:4px;">{{ $ordersOnProgress }}</div>
      <div style="font-size:11px; color:#2563eb; margin-top:2px;">Sedang tahap produksi / las</div>
    </div>
    <div style="background:#d1fae5; border:1px solid #a7f3d0; border-radius:12px; padding:16px;">
      <div style="font-size:12px; font-weight:700; color:#065f46;">SELESAI</div>
      <div style="font-size:22px; font-weight:800; color:#065f46; margin-top:4px;">{{ $ordersSelesai }}</div>
      <div style="font-size:11px; color:#059669; margin-top:2px;">Selesai terpasang / terkirim</div>
    </div>
    <div style="background:#fee2e2; border:1px solid #fecaca; border-radius:12px; padding:16px;">
      <div style="font-size:12px; font-weight:700; color:#991b1b;">CANCELLED</div>
      <div style="font-size:22px; font-weight:800; color:#991b1b; margin-top:4px;">{{ $ordersCancelled }}</div>
      <div style="font-size:11px; color:#dc2626; margin-top:2px;">Dibatalkan</div>
    </div>
  </div>
</div>

<!-- Main Section Grid: Recent Orders & Activity Logs -->
<div class="grid grid-2">
  <!-- Recent Orders -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Pesanan Terbaru</h3>
      <a href="{{ route('status_order.index') }}" class="btn btn-sm btn-secondary">Lihat Semua</a>
    </div>
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>Order</th>
            <th>Total</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @forelse($recentOrders as $ord)
            <tr>
              <td>
                <strong>#{{ $ord->id }} - {{ $ord->nama_pelanggan }}</strong>
                <div style="font-size:11px; color:var(--text-muted);">
                  {{ $ord->created_at ? $ord->created_at->diffForHumans() : '-' }}
                </div>
              </td>
              <td>
                <strong>Rp {{ number_format($ord->total, 0, ',', '.') }}</strong>
              </td>
              <td>
                <span class="badge {{ $ord->status_badge_class }}">
                  {{ $ord->status_label }}
                </span>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="3" style="text-align:center; color:var(--text-muted); padding:20px;">
                Belum ada pesanan terbaru.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- Recent Activity Log -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Log Aktivitas Terbaru</h3>
      <a href="{{ route('activity_log.index') }}" class="btn btn-sm btn-secondary">Lihat Semua</a>
    </div>
    <div style="display:flex; flex-direction:column; gap:12px;">
      @forelse($recentLogs as $log)
        <div style="display:flex; align-items:flex-start; gap:12px; padding-bottom:12px; border-bottom:1px solid var(--border-color);">
          <div style="width:32px; height:32px; border-radius:50%; background:var(--bg-main); display:flex; align-items:center; justify-content:center; font-size:14px;">
            👤
          </div>
          <div style="flex:1;">
            <div style="font-size:13px; font-weight:600; color:var(--text-main);">
              {{ $log->username }} <span style="font-weight:400; color:var(--text-muted);">({{ $log->module }})</span>
            </div>
            <div style="font-size:12px; color:var(--text-muted); margin-top:2px;">
              {{ $log->description }}
            </div>
            <div style="font-size:11px; color:var(--text-muted); margin-top:4px;">
              {{ $log->created_at->diffForHumans() }}
            </div>
          </div>
        </div>
      @empty
        <div style="text-align:center; color:var(--text-muted); padding:20px;">Belum ada aktivitas tercatat.</div>
      @endforelse
    </div>
  </div>
</div>
@endsection
