@extends('layouts.app')

@section('title', 'Struk Transaksi #' . $order->id)

@section('styles')
<style>
  .receipt-card {
    max-width: 400px;
    margin: 0 auto;
    background: #fff;
    color: #000;
    padding: 24px;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    font-family: 'Courier New', Courier, monospace;
  }

  .receipt-header {
    text-align: center;
    border-bottom: 1px dashed #000;
    padding-bottom: 12px;
    margin-bottom: 12px;
  }

  .receipt-item {
    display: flex;
    justify-content: space-between;
    font-size: 13px;
    margin-bottom: 6px;
  }

  .receipt-footer {
    border-top: 1px dashed #000;
    padding-top: 12px;
    margin-top: 12px;
    text-align: center;
    font-size: 12px;
  }

  @media print {
    body * { visibility: hidden; }
    .receipt-card, .receipt-card * { visibility: visible; }
    .receipt-card { position: absolute; left: 0; top: 0; width: 100%; box-shadow: none; }
    .no-print { display: none; }
  }
</style>
@endsection

@section('content')
<div class="no-print" style="max-width:400px; margin:0 auto 16px; display:flex; gap:10px;">
  <a href="{{ route('kasir.index') }}" class="btn btn-secondary" style="flex:1;">⬅ Kembali ke Kasir</a>
  <button class="btn btn-primary" onclick="window.print()" style="flex:1;">🖨️ Cetak Struk</button>
</div>

<div class="receipt-card">
  <div class="receipt-header">
    <h2 style="font-size:18px; margin-bottom:4px;">DAPURKU RESTO</h2>
    <div style="font-size:12px;">{{ $order->branch ? $order->branch->nama_cabang : 'Cabang Utama' }}</div>
    <div style="font-size:11px; margin-top:4px;">Order #{{ $order->id }} | {{ $order->created_at->format('d/m/Y H:i') }}</div>
    <div style="font-size:11px;">Kasir: {{ $order->user ? $order->user->username : 'Kasir' }} ({{ $order->kategori }})</div>
  </div>

  <div style="margin-bottom:12px;">
    @foreach($order->items as $item)
      <div class="receipt-item">
        <span>{{ $item->produk }}</span>
        <span>Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
      </div>
    @endforeach
  </div>

  <div style="border-top:1px dashed #000; padding-top:8px;">
    <div class="receipt-item" style="font-weight:bold; font-size:15px;">
      <span>TOTAL</span>
      <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
    </div>
  </div>

  @if($order->keterangan)
    <div style="font-size:11px; margin-top:8px; font-style:italic;">
      Note: {{ $order->keterangan }}
    </div>
  @endif

  <div class="receipt-footer">
    Terima kasih atas kunjungan Anda!<br>
    Selamat menikmati hidangan 🍳
  </div>
</div>
@endsection
