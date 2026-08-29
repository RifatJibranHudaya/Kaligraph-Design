@extends('layouts.app')

@section('title', 'Riwayat Transaksi POS')

@section('content')
<div class="card">
  <div class="card-header">
    <h3 class="card-title">📜 Daftar Riwayat Transaksi</h3>
    <a href="{{ route('kasir.index') }}" class="btn btn-primary">🛒 Buka POS Kasir</a>
  </div>

  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Waktu</th>
          <th>Kasir</th>
          <th>Kategori</th>
          <th>Item Pesanan</th>
          <th>Total Bayar</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($orders as $o)
          <tr>
            <td>#{{ $o->id }}</td>
            <td>{{ $o->created_at->format('d/m/Y H:i') }}</td>
            <td><strong>{{ $o->user ? $o->user->username : '-' }}</strong></td>
            <td><span class="badge badge-primary">{{ $o->kategori }}</span></td>
            <td>
              <span style="font-size:13px; color:var(--text-muted);">
                {{ $o->items->count() }} item ({{ $o->items->pluck('produk')->take(3)->implode(', ') }}...)
              </span>
            </td>
            <td><strong style="color:var(--primary);">Rp {{ number_format($o->total, 0, ',', '.') }}</strong></td>
            <td>
              <a href="{{ route('kasir.receipt', $o->id) }}" class="btn btn-sm btn-secondary">🖨️ Struk</a>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" style="text-align:center; color:var(--text-muted); padding:30px;">
              Belum ada riwayat transaksi.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div style="margin-top:16px;">
    {{ $orders->links() }}
  </div>
</div>
@endsection
