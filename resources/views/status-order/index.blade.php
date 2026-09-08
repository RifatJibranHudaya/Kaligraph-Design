@extends('layouts.app')

@section('title', 'Status Pengerjaan Order')

@section('styles')
<style>
  .status-tabs {
    display: flex;
    gap: 10px;
    margin-bottom: 24px;
    overflow-x: auto;
    padding-bottom: 6px;
  }
  .status-tab {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    border-radius: 12px;
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    color: var(--text-main);
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    transition: all 0.2s;
  }
  .status-tab:hover, .status-tab.active {
    background: var(--primary);
    color: #fff;
    border-color: var(--primary);
    box-shadow: 0 4px 12px rgba(37,99,235,0.25);
  }
  .status-tab .tab-badge {
    background: rgba(0,0,0,0.08);
    color: inherit;
    padding: 2px 8px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
  }
  .status-tab.active .tab-badge {
    background: rgba(255,255,255,0.25);
  }

  .order-card {
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 16px;
    padding: 20px;
    margin-bottom: 16px;
    box-shadow: var(--shadow-sm);
    transition: transform 0.2s;
  }
  .order-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
  }

  .status-select {
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
    border: 1px solid var(--border-color);
    cursor: pointer;
    background: var(--bg-main);
    color: var(--text-main);
  }
</style>
@endsection

@section('content')

<!-- Header & Add Order Button -->
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:16px;">
  <div>
    <h2 style="font-size:22px; font-weight:800; color:var(--text-main);">Tracking & Status Pengerjaan</h2>
    <p style="font-size:13px; color:var(--text-muted); margin-top:2px;">Pantau progres pengerjaan mulai dari pesanan masuk, on progress pengerjaan, selesai, hingga cancelled.</p>
  </div>
  <button type="button" class="btn btn-primary" onclick="document.getElementById('newOrderModal').style.display='flex'">
    Buat Pesanan / Order Baru
  </button>
</div>

<!-- Status Tabs Filter -->
<div class="status-tabs">
  <a href="{{ route('status_order.index', ['status' => 'semua']) }}" class="status-tab {{ !request('status') || request('status') === 'semua' ? 'active' : '' }}">
    <span>Semua</span>
    <span class="tab-badge">{{ $statusCounts['semua'] }}</span>
  </a>
  <a href="{{ route('status_order.index', ['status' => 'order']) }}" class="status-tab {{ request('status') === 'order' ? 'active' : '' }}">
    <span>Order Baru</span>
    <span class="tab-badge">{{ $statusCounts['order'] }}</span>
  </a>
  <a href="{{ route('status_order.index', ['status' => 'on_progress']) }}" class="status-tab {{ request('status') === 'on_progress' ? 'active' : '' }}">
    <span>On Progress</span>
    <span class="tab-badge">{{ $statusCounts['on_progress'] }}</span>
  </a>
  <a href="{{ route('status_order.index', ['status' => 'selesai']) }}" class="status-tab {{ request('status') === 'selesai' ? 'active' : '' }}">
    <span>Selesai</span>
    <span class="tab-badge">{{ $statusCounts['selesai'] }}</span>
  </a>
  <a href="{{ route('status_order.index', ['status' => 'cancelled']) }}" class="status-tab {{ request('status') === 'cancelled' ? 'active' : '' }}">
    <span>Cancelled</span>
    <span class="tab-badge">{{ $statusCounts['cancelled'] }}</span>
  </a>
</div>

<!-- Search Bar -->
<div class="card" style="padding:16px; margin-bottom:24px;">
  <form method="GET" action="{{ route('status_order.index') }}" style="display:flex; gap:12px; align-items:center;">
    @if(request('status'))
      <input type="hidden" name="status" value="{{ request('status') }}">
    @endif
    <input type="text" name="search" class="form-control" placeholder="Cari nama pelanggan, nomor HP, atau ID Order..." value="{{ request('search') }}" style="flex:1;">
    <button type="submit" class="btn btn-primary">Cari</button>
    @if(request('search'))
      <a href="{{ route('status_order.index', ['status' => request('status')]) }}" class="btn btn-secondary">Reset</a>
    @endif
  </form>
</div>

<!-- Order List -->
<div class="table-responsive card" style="padding:0; overflow:hidden;">
  <table class="table">
    <thead>
      <tr>
        <th>No. Order & Pelanggan</th>
        <th>Alamat & Kategori</th>
        <th>Nilai Proyek</th>
        <th>Status Pembayaran</th>
        <th>Status Pengerjaan</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($orders as $ord)
        <tr>
          <td>
            <div style="font-weight:800; font-size:15px; color:var(--text-main);">
              Order #{{ $ord->id }}
            </div>
            <div style="font-size:13px; font-weight:600; color:var(--primary); margin-top:2px;">
              👤 {{ $ord->nama_pelanggan }}
            </div>
            @if($ord->no_hp)
              <div style="font-size:12px; color:var(--text-muted); margin-top:2px;">
                📞 {{ $ord->no_hp }}
              </div>
            @endif
            <div style="font-size:11px; color:var(--text-muted); margin-top:4px;">
              📅 {{ $ord->created_at ? $ord->created_at->format('d/m/Y H:i') : '-' }}
            </div>
          </td>
          <td>
            @if($ord->kategori)
              <span class="badge badge-purple" style="margin-bottom:4px;">{{ $ord->kategori }}</span>
            @endif
            <div style="font-size:12px; color:var(--text-muted); max-width:240px; line-height:1.4;">
              {{ $ord->alamat ?: '-' }}
            </div>
            @if($ord->keterangan)
              <div style="font-size:11px; color:var(--text-muted); margin-top:4px; font-style:italic;">
                Catatan: {{ Str::limit($ord->keterangan, 50) }}
              </div>
            @endif
          </td>
          <td>
            <div style="font-weight:800; font-size:15px; color:var(--text-main);">
              Rp {{ number_format($ord->total, 0, ',', '.') }}
            </div>
          </td>
          <td>
            @php
              $dibayar = $ord->total_dibayar;
              $total = $ord->total;
              $sisa = $ord->sisa_tagihan;
            @endphp
            @if($dibayar >= $total && $total > 0)
              <span class="badge badge-success">Lunas (100%)</span>
            @elseif($dibayar > 0)
              <span class="badge badge-warning">DP Rp {{ number_format($dibayar, 0, ',', '.') }}</span>
              <div style="font-size:11px; color:var(--danger); font-weight:600; margin-top:2px;">
                Sisa: Rp {{ number_format($sisa, 0, ',', '.') }}
              </div>
            @else
              <span class="badge badge-danger">Belum Bayar</span>
            @endif
          </td>
          <td>
            <form method="POST" action="{{ route('status_order.update_status', $ord->id) }}">
              @csrf
              @method('PUT')
              <select name="status" class="status-select" onchange="this.form.submit()" style="
                @if($ord->status === 'selesai') background:#d1fae5; color:#065f46; border-color:#a7f3d0;
                @elseif($ord->status === 'on_progress') background:#dbeafe; color:#1e40af; border-color:#bfdbfe;
                @elseif($ord->status === 'cancelled') background:#fee2e2; color:#991b1b; border-color:#fecaca;
                @else background:#fef3c7; color:#92400e; border-color:#fde68a;
                @endif
              ">
                <option value="order" {{ $ord->status === 'order' ? 'selected' : '' }}>Order (Baru)</option>
                <option value="on_progress" {{ $ord->status === 'on_progress' ? 'selected' : '' }}>On Progress</option>
                <option value="selesai" {{ $ord->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="cancelled" {{ $ord->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
              </select>
            </form>
          </td>
          <td>
            <div style="display:flex; flex-direction:column; gap:6px;">
              <a href="{{ route('pembayaran.index', ['order_id' => $ord->id]) }}" class="btn btn-sm btn-secondary" style="font-size:11px;">
                Catat Bayar
              </a>
              @if(Route::has('kasir.receipt'))
                <a href="{{ route('kasir.receipt', $ord->id) }}" target="_blank" class="btn btn-sm btn-secondary" style="font-size:11px;">
                Nota / Resi
                </a>
              @endif
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="6" style="text-align:center; color:var(--text-muted); padding:40px;">
            Tidak ada data order untuk filter ini.
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

<div style="margin-top:20px;">
  {{ $orders->withQueryString()->links() }}
</div>

<!-- Modal Tambah Order Baru -->
<div id="newOrderModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); z-index:9999; align-items:center; justify-content:center; padding:20px;">
  <div class="card" style="width:100%; max-width:540px; background:var(--bg-card); margin:0; border-radius:20px; box-shadow:0 25px 50px -12px rgba(0,0,0,0.25); max-height:90vh; overflow-y:auto;">
    <div class="card-header">
      <h3 class="card-title">Buat Pesanan / Order Baru</h3>
      <button type="button" onclick="document.getElementById('newOrderModal').style.display='none'" style="background:none; border:none; font-size:20px; cursor:pointer; color:var(--text-main);">✕</button>
    </div>
    <form method="POST" action="{{ route('status_order.store') }}">
      @csrf
      <div class="form-group">
        <label class="form-label">Nama Pelanggan *</label>
        <input type="text" name="nama_pelanggan" class="form-control" placeholder="cth. Bpk. Hendra - Toko Sentosa" required>
      </div>

      <div class="grid grid-2">
        <div class="form-group">
          <label class="form-label">Nomor WhatsApp / HP</label>
          <input type="text" name="no_hp" class="form-control" placeholder="cth. 081234567890">
        </div>
        <div class="form-group">
          <label class="form-label">Kategori Pekerjaan</label>
          <input type="text" name="kategori" class="form-control" placeholder="cth. Neon Box, Kanopi, Huruf Timbul">
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Total Nilai Tagihan (Rp) *</label>
        <input type="number" name="total" class="form-control" placeholder="cth. 1500000" min="0" required>
      </div>

      <div class="form-group">
        <label class="form-label">Alamat / Lokasi Pemasangan</label>
        <textarea name="alamat" class="form-control" rows="2" placeholder="Alamat lengkap tujuan kirim atau survey lokasi..."></textarea>
      </div>

      <div class="form-group">
        <label class="form-label">Catatan Spesifikasi / Ukuran</label>
        <textarea name="keterangan" class="form-control" rows="2" placeholder="cth. Ukuran 120x60cm, LED putih super bright, bracket siku besi..."></textarea>
      </div>

      <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:20px;">
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('newOrderModal').style.display='none'">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Order ➔</button>
      </div>
    </form>
  </div>
</div>

@endsection
