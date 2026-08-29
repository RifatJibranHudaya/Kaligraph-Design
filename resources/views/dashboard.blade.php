@extends('layouts.app')

@section('title', 'Dashboard Analytics')

@section('content')
<!-- Stat Cards -->
<div class="grid grid-4" style="margin-bottom: 28px;">
  <div class="card" style="margin-bottom:0;">
    <div style="display:flex; justify-content:space-between; align-items:center;">
      <div>
        <div style="font-size:13px; font-weight:600; color:var(--text-muted);">Total Omset Penjualan</div>
        <div style="font-size:24px; font-weight:800; color:var(--primary); margin-top:6px;">
          Rp {{ number_format($totalOmset, 0, ',', '.') }}
        </div>
      </div>
      <div style="width:48px; height:48px; border-radius:12px; background:#ffedd5; display:flex; align-items:center; justify-content:center; font-size:24px;">
        💰
      </div>
    </div>
  </div>

  <div class="card" style="margin-bottom:0;">
    <div style="display:flex; justify-content:space-between; align-items:center;">
      <div>
        <div style="font-size:13px; font-weight:600; color:var(--text-muted);">Total Transaksi</div>
        <div style="font-size:24px; font-weight:800; color:var(--accent); margin-top:6px;">
          {{ number_format($totalOrders, 0, ',', '.') }}
        </div>
      </div>
      <div style="width:48px; height:48px; border-radius:12px; background:#dbeafe; display:flex; align-items:center; justify-content:center; font-size:24px;">
        🛒
      </div>
    </div>
  </div>

  <div class="card" style="margin-bottom:0;">
    <div style="display:flex; justify-content:space-between; align-items:center;">
      <div>
        <div style="font-size:13px; font-weight:600; color:var(--text-muted);">Produk Aktif</div>
        <div style="font-size:24px; font-weight:800; color:var(--success); margin-top:6px;">
          {{ $totalProducts }}
        </div>
      </div>
      <div style="width:48px; height:48px; border-radius:12px; background:#d1fae5; display:flex; align-items:center; justify-content:center; font-size:24px;">
        🍱
      </div>
    </div>
  </div>

  <div class="card" style="margin-bottom:0;">
    <div style="display:flex; justify-content:space-between; align-items:center;">
      <div>
        <div style="font-size:13px; font-weight:600; color:var(--text-muted);">Total Pengeluaran</div>
        <div style="font-size:24px; font-weight:800; color:var(--danger); margin-top:6px;">
          Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
        </div>
      </div>
      <div style="width:48px; height:48px; border-radius:12px; background:#fee2e2; display:flex; align-items:center; justify-content:center; font-size:24px;">
        📉
      </div>
    </div>
  </div>
</div>

<!-- Main Section Grid -->
<div class="grid grid-2">
  <!-- Recent Activity Log -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">📜 Log Aktivitas Terbaru</h3>
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

  <!-- Recent Stock Activity -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">📦 Pergerakan Stok Terbaru</h3>
      <a href="{{ route('stok.index') }}" class="btn btn-sm btn-secondary">Kelola Stok</a>
    </div>
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>Tanggal</th>
            <th>Produk</th>
            <th>Tipe</th>
            <th>Jumlah</th>
          </tr>
        </thead>
        <tbody>
          @forelse($recentStockRecords as $stok)
            <tr>
              <td>{{ $stok->tanggal ? $stok->tanggal->format('d/m/Y') : '-' }}</td>
              <td><strong>{{ $stok->produk }}</strong></td>
              <td>
                <span class="badge {{ $stok->tipe === 'masuk' ? 'badge-success' : 'badge-danger' }}">
                  {{ strtoupper($stok->tipe) }}
                </span>
              </td>
              <td>{{ $stok->jumlah }} {{ $stok->satuan }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="4" style="text-align:center; color:var(--text-muted);">Belum ada catatan stok.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
