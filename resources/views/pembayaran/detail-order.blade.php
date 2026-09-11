@extends('layouts.app')

@section('title', 'Detail Pembayaran Order #' . $order->id)

@section('styles')
<style>
  .detail-header {
    background: linear-gradient(135deg, var(--primary), #60a5fa);
    color: #ffffff;
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 24px;
    box-shadow: 0 10px 25px rgba(37, 99, 235, 0.25);
  }
  
  .status-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 700;
  }
  
  .status-lunas {
    background: #d1fae5;
    color: #065f46;
  }
  
  .status-belum-lunas {
    background: #fef3c7;
    color: #92400e;
  }
  
  .payment-card {
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 12px;
    transition: all 0.2s;
  }
  
  .payment-card:hover {
    border-color: var(--primary);
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
  }
  
  .progress-bar-container {
    background: #e5e7eb;
    border-radius: 10px;
    height: 12px;
    overflow: hidden;
    margin-top: 8px;
  }
  
  .progress-bar-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--success), #34d399);
    border-radius: 10px;
    transition: width 0.3s ease;
  }
  
  .wa-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 14px 28px;
    background: #25D366;
    color: #ffffff;
    font-weight: 700;
    font-size: 15px;
    border-radius: 12px;
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
  
  .form-section {
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 24px;
  }
</style>
@endsection

@section('content')
<!-- Header Detail Order -->
<div class="detail-header">
  <div style="display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:16px;">
    <div>
      <h2 style="font-size:24px; font-weight:800; margin-bottom:8px;">
        Order #{{ $order->id }}
      </h2>
      <p style="font-size:14px; opacity:0.9; margin:0;">
        👤 {{ $order->nama_pelanggan }} 
        @if($order->no_hp) • 📞 {{ $order->no_hp }} @endif
      </p>
      @if($order->kategori)
        <span style="font-size:12px; opacity:0.8; display:block; margin-top:4px;">
          📂 {{ $order->kategori }}
        </span>
      @endif
    </div>
    <div style="text-align:right;">
      <span class="status-badge {{ $isLunas ? 'status-lunas' : 'status-belum-lunas' }}">
        @if($isLunas)
          ✅ LUNAS
        @else
          ⏳ BELUM LUNAS
        @endif
      </span>
      <div style="margin-top:12px; font-size:13px; opacity:0.9;">
        Status Pengerjaan:
        <strong style="display:block; margin-top:4px; font-size:15px;">
          @php
            $statusLabels = [
              'order' => '📋 Order Baru',
              'on_progress' => '🔧 Sedang Dikerjakan',
              'selesai' => '✅ Selesai',
              'cancelled' => '❌ Dibatalkan',
            ];
          @endphp
          {{ $statusLabels[$order->status] ?? $order->status }}
        </strong>
      </div>
    </div>
  </div>
</div>

<div class="grid grid-2" style="align-items:start;">
  <!-- Form Pembayaran & Riwayat -->
  <div>
    <!-- Form Catat Pembayaran -->
    <div class="form-section">
      <h3 style="font-size:18px; font-weight:700; margin-bottom:16px; color:var(--text-main);">
        💳 Catat Pembayaran Baru
      </h3>
      <form method="POST" action="{{ route('pembayaran.store') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="order_id" value="{{ $order->id }}">
        
        <div class="grid grid-2">
          <div class="form-group">
            <label class="form-label">Jumlah Pembayaran (Rp) *</label>
            <input type="number" name="jumlah" class="form-control" placeholder="cth. 500000" min="1" required>
          </div>
          <div class="form-group">
            <label class="form-label">Metode Pembayaran *</label>
            <select name="metode" class="form-control" required>
              <option value="transfer">Transfer Bank / QRIS</option>
              <option value="cash">Tunai / Cash</option>
              <option value="dp">Uang Muka (DP)</option>
            </select>
          </div>
        </div>

        <div class="grid grid-2">
          <div class="form-group">
            <label class="form-label">Tanggal Bayar *</label>
            <input type="date" name="tanggal_bayar" class="form-control" value="{{ date('Y-m-d') }}" required>
          </div>
          <div class="form-group">
            <label class="form-label">Bukti Transfer (Opsional)</label>
            <input type="file" name="bukti" class="form-control" accept="image/*">
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Catatan / Keterangan</label>
          <textarea name="keterangan" class="form-control" rows="2" placeholder="cth. DP 50% awal via BCA..."></textarea>
        </div>

        <button type="submit" class="btn btn-primary" style="width:100%;">Simpan Pembayaran ➔</button>
      </form>
    </div>

    <!-- Riwayat Pembayaran -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">📝 Riwayat Pembayaran</h3>
      </div>
      
      @forelse($allPayments as $pay)
        <div class="payment-card">
          <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:12px;">
            <div style="flex:1;">
              <div style="display:flex; align-items:center; gap:8px; margin-bottom:8px;">
                <span class="badge {{ $pay->metode === 'dp' ? 'badge-warning' : ($pay->metode === 'transfer' ? 'badge-primary' : 'badge-success') }}">
                  {{ strtoupper($pay->metode) }}
                </span>
                <span style="font-size:12px; color:var(--text-muted);">
                  {{ $pay->tanggal_bayar ? $pay->tanggal_bayar->format('d/m/Y H:i') : '-' }}
                </span>
              </div>
              <div style="font-size:18px; font-weight:800; color:var(--success);">
                Rp {{ number_format($pay->jumlah, 0, ',', '.') }}
              </div>
              @if($pay->keterangan)
                <div style="font-size:12px; color:var(--text-muted); margin-top:4px;">
                  {{ $pay->keterangan }}
                </div>
              @endif
              @if($pay->user)
                <div style="font-size:11px; color:var(--text-muted); margin-top:4px;">
                  Dicatat oleh: {{ $pay->user->username }}
                </div>
              @endif
            </div>
            <div style="display:flex; gap:6px; flex-direction:column;">
              <a href="{{ route('pembayaran.nota', $pay->id) }}" target="_blank" class="btn btn-sm btn-secondary">
                🖨️ Nota
              </a>
              @if($pay->bukti_url)
                <a href="{{ $pay->bukti_url }}" target="_blank" class="btn btn-sm btn-info" style="font-size:11px;">
                  🖼️ Bukti
                </a>
              @endif
            </div>
          </div>
        </div>
      @empty
        <div style="text-align:center; padding:30px; color:var(--text-muted);">
          Belum ada pembayaran yang tercatat untuk order ini.
        </div>
      @endforelse
    </div>
  </div>

  <!-- Summary & Kirim WA -->
  <div>
    <!-- Ringkasan Pembayaran -->
    <div class="card" style="position:sticky; top:90px;">
      <div class="card-header">
        <h3 class="card-title">💰 Ringkasan Pembayaran</h3>
      </div>
      
      <div style="padding:16px 0;">
        <div style="display:flex; justify-content:space-between; margin-bottom:12px; font-size:14px;">
          <span style="color:var(--text-muted);">Total Tagihan</span>
          <span style="font-weight:700; color:var(--text-main);">
            Rp {{ number_format($orderTotal, 0, ',', '.') }}
          </span>
        </div>
        <div style="display:flex; justify-content:space-between; margin-bottom:12px; font-size:14px;">
          <span style="color:var(--text-muted);">Total Dibayar</span>
          <span style="font-weight:700; color:var(--success);">
            Rp {{ number_format($totalPaid, 0, ',', '.') }}
          </span>
        </div>
        <div style="display:flex; justify-content:space-between; margin-bottom:16px; font-size:14px; padding-top:12px; border-top:1px solid var(--border-color);">
          <span style="color:var(--text-muted);">Sisa Tagihan</span>
          <span style="font-weight:800; color:var(--danger);">
            Rp {{ number_format($sisaTagihan, 0, ',', '.') }}
          </span>
        </div>

        <!-- Progress Bar -->
        @php
          $progressPercent = $orderTotal > 0 ? min(100, ($totalPaid / $orderTotal) * 100) : 0;
        @endphp
        <div style="margin-bottom:16px;">
          <div style="display:flex; justify-content:space-between; font-size:12px; margin-bottom:6px;">
            <span style="color:var(--text-muted);">Progress Pembayaran</span>
            <span style="font-weight:700; color:var(--primary);">{{ number_format($progressPercent, 0) }}%</span>
          </div>
          <div class="progress-bar-container">
            <div class="progress-bar-fill" style="width:{{ $progressPercent }}%;"></div>
          </div>
        </div>

        <!-- Info Status -->
        <div style="background:{{ $isLunas ? '#d1fae5' : '#fef3c7' }}; border-radius:10px; padding:12px; margin-bottom:20px;">
          <div style="font-size:13px; font-weight:700; color:{{ $isLunas ? '#065f46' : '#92400e' }};">
            @if($isLunas)
              ✅ Order ini sudah LUNAS
            @elseif($totalPaid > 0)
              ⏳ DP diterima, sisa Rp {{ number_format($sisaTagihan, 0, ',', '.') }}
            @else
              ⚠️ Belum ada pembayaran
            @endif
          </div>
        </div>

        <!-- Tombol Aksi -->
        <div style="display:flex; flex-direction:column; gap:10px;">
          @php $firstPayment = $allPayments && count($allPayments) > 0 ? $allPayments[0] : null; @endphp
          <a href="{{ $firstPayment ? route('pembayaran.nota', $firstPayment->id) : '#' }}" target="_blank" class="btn btn-secondary" style="justify-content:center;">
            🖨️ Cetak Nota
          </a>
          <button type="button" class="btn btn-primary" onclick="document.getElementById('sendWaModal').style.display='flex'" style="justify-content:center;">
            📤 Kirim Nota ke WhatsApp
          </button>
          <a href="{{ route('status_order.index') }}" class="btn btn-secondary" style="justify-content:center;">
            ← Kembali ke Status Order
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Kirim WhatsApp -->
<div id="sendWaModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); z-index:9999; align-items:center; justify-content:center; padding:20px;">
  <div class="card" style="width:100%; max-width:500px; background:var(--bg-card); margin:0; border-radius:20px; box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);">
    <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
      <h3 class="card-title">📤 Kirim Nota ke WhatsApp</h3>
      <button type="button" onclick="document.getElementById('sendWaModal').style.display='none'" style="background:none; border:none; font-size:20px; cursor:pointer; color:var(--text-main);">✕</button>
    </div>
    
    <form method="POST" action="{{ route('pembayaran.send.whatsapp', $order->id) }}">
      @csrf
      <div style="padding:0 24px 24px;">
        <div class="form-group">
          <label class="form-label">Nomor WhatsApp Pelanggan *</label>
          <input type="text" name="nomor_wa" class="form-control" value="{{ old('nomor_wa', session('nomor_wa', $order->no_hp)) }}" placeholder="cth. 081234567890" required>
          <small style="color:var(--text-muted); font-size:12px; display:block; margin-top:4px;">
            Nomor akan otomatis diformat ke standar WhatsApp.
          </small>
        </div>

        <div class="form-group">
          <label class="form-label">Pesan Tambahan (Opsional)</label>
          <textarea name="pesan_tambahan" class="form-control" rows="3" placeholder="Tambahkan pesan pribadi untuk pelanggan...">{{ old('pesan_tambahan') }}</textarea>
        </div>

        <!-- Preview Nota -->
        <div style="background:#f9fafb; border:1px solid var(--border-color); border-radius:10px; padding:12px; margin-top:16px;">
          <div style="font-size:12px; font-weight:700; color:var(--text-muted); margin-bottom:8px;">PREVIEW PESAN:</div>
          <div style="font-size:11px; line-height:1.5; color:#374151;">
            *NOTA PEMBAYARAN ORDER #{{ $order->id }}*<br>
            ━━━━━━━━━━━━━━━━━━━━<br>
            📋 *Detail Order*<br>
            Nama: {{ $order->nama_pelanggan }}<br>
            Total: Rp {{ number_format($orderTotal, 0, ',', '.') }}<br>
            Dibayar: Rp {{ number_format($totalPaid, 0, ',', '.') }}<br>
            Sisa: Rp {{ number_format($sisaTagihan, 0, ',', '.') }}<br>
            Status: {{ $isLunas ? 'LUNAS ✅' : 'BELUM LUNAS ⏳' }}<br>
            Progress: {{ $statusLabels[$order->status] ?? $order->status }}
          </div>
        </div>

        @if(session('wa_url'))
          <div style="margin-top:16px; padding:12px; background:#d1fae5; border-radius:10px; text-align:center;">
            <div style="font-size:13px; font-weight:700; color:#065f46; margin-bottom:8px;">
              ✅ Nota berhasil disiapkan!
            </div>
            <a href="{{ session('wa_url') }}" target="_blank" class="wa-button" style="padding:10px 20px; font-size:14px;">
              <span>💬</span> Buka WhatsApp Sekarang
            </a>
          </div>
        @endif

        <div style="display:flex; gap:10px; margin-top:20px;">
          <button type="button" class="btn btn-secondary" onclick="document.getElementById('sendWaModal').style.display='none'" style="flex:1;">Batal</button>
          <button type="submit" class="btn btn-primary" style="flex:1;">
            <span>📤</span> Kirim ke WhatsApp
          </button>
        </div>
      </div>
    </form>
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
