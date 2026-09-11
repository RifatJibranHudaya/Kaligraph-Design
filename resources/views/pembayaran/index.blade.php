@extends('layouts.app')

@section('title', 'Data Pembayaran & DP')

@section('content')
<div class="grid grid-2">
  <!-- Form Catat Pembayaran -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Catat Pembayaran Baru</h3>
    </div>
    <form method="POST" action="{{ route('pembayaran.store') }}" enctype="multipart/form-data">
      @csrf
      <div class="form-group">
        <label class="form-label">Pilih Order Terkait *</label>
        <select name="order_id" class="form-control" required>
          <option value="">-- Pilih Order --</option>
          @foreach($orders as $ord)
            <option value="{{ $ord->id }}" {{ old('order_id', request('order_id')) == $ord->id ? 'selected' : '' }}>
              Order #{{ $ord->id }} — {{ $ord->nama_pelanggan }} (Total: Rp {{ number_format($ord->total, 0, ',', '.') }})
            </option>
          @endforeach
        </select>
      </div>

      <div class="grid grid-2">
        <div class="form-group">
          <label class="form-label">Jumlah Pembayaran (Rp) *</label>
          <input type="number" name="jumlah" class="form-control" placeholder="cth. 500000" min="1" value="{{ old('jumlah') }}" required>
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
          <label class="form-label">Bukti Transfer / Nota (Opsional)</label>
          <input type="file" name="bukti" class="form-control" accept="image/*">
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Catatan / Keterangan</label>
        <textarea name="keterangan" class="form-control" rows="2" placeholder="cth. DP 50% awal via BCA, pelunasan saat selesai...">{{ old('keterangan') }}</textarea>
      </div>

      <button type="submit" class="btn btn-primary" style="width:100%;">Simpan Pembayaran ➔</button>
    </form>
  </div>

  <!-- Filter & Summary -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Filter & Riwayat Pembayaran</h3>
    </div>
    
    <!-- Filter form -->
    <form method="GET" action="{{ route('pembayaran.index') }}" style="display:flex; gap:10px; margin-bottom:20px; flex-wrap:wrap;">
      <select name="metode" class="form-control" style="width:auto; flex:1;" onchange="this.form.submit()">
        <option value="">Semua Metode</option>
        <option value="transfer" {{ request('metode') === 'transfer' ? 'selected' : '' }}>Transfer</option>
        <option value="cash" {{ request('metode') === 'cash' ? 'selected' : '' }}>Cash</option>
        <option value="dp" {{ request('metode') === 'dp' ? 'selected' : '' }}>DP</option>
      </select>
      @if(request('order_id'))
        <input type="hidden" name="order_id" value="{{ request('order_id') }}">
        <a href="{{ route('pembayaran.index') }}" class="btn btn-secondary">Reset Filter</a>
      @endif
    </form>

    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>Order</th>
            <th>Tanggal</th>
            <th>Metode</th>
            <th>Jumlah</th>
            <th>Bukti</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($payments as $pay)
            <tr>
              <td>
                <strong>#{{ $pay->order_id }}</strong>
                <div style="font-size:12px; color:var(--text-muted);">
                  {{ $pay->order ? $pay->order->nama_pelanggan : 'Order dihapus' }}
                </div>
              </td>
              <td>{{ $pay->tanggal_bayar ? $pay->tanggal_bayar->format('d/m/Y') : '-' }}</td>
              <td>
                <span class="badge {{ $pay->metode === 'dp' ? 'badge-warning' : ($pay->metode === 'transfer' ? 'badge-primary' : 'badge-success') }}">
                  {{ strtoupper($pay->metode) }}
                </span>
              </td>
              <td>
                <strong style="color:var(--success);">
                  Rp {{ number_format($pay->jumlah, 0, ',', '.') }}
                </strong>
                @if($pay->keterangan)
                  <div style="font-size:11px; color:var(--text-muted);">{{ Str::limit($pay->keterangan, 30) }}</div>
                @endif
              </td>
              <td>
                @if($pay->bukti_url)
                  <a href="{{ $pay->bukti_url }}" target="_blank" style="font-size:12px; color:var(--primary); font-weight:600; text-decoration:none;">
                    🖼️ Lihat
                  </a>
                @else
                  <span style="color:var(--text-muted); font-size:12px;">-</span>
                @endif
              </td>
              <td>
                <div style="display:flex; gap:6px; align-items:center;">
                  <a href="{{ route('pembayaran.nota', $pay->id) }}" target="_blank" class="btn btn-sm btn-secondary" style="font-size:11px; padding:4px 8px; white-space:nowrap;" title="Cetak Nota Pembayaran">
                    🖨️ Nota
                  </a>
                  <form method="POST" action="{{ route('pembayaran.destroy', $pay->id) }}" onsubmit="return confirm('Hapus data pembayaran ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" style="padding:4px 8px;" title="Hapus Pembayaran">🗑️</button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" style="text-align:center; color:var(--text-muted); padding:30px;">
                Belum ada data pembayaran.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div style="margin-top:20px;">
      {{ $payments->withQueryString()->links() }}
    </div>
  </div>
</div>
@endsection
