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
              <a href="{{ route('pembayaran.detail.order', $ord->id) }}" class="btn btn-sm btn-primary" style="font-size:11px;">
                💳 Detail Bayar
              </a>
              <a href="{{ route('pembayaran.index', ['order_id' => $ord->id]) }}" class="btn btn-sm btn-secondary" style="font-size:11px;">
                Catat Bayar
              </a>
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
      
      <!-- Nama Pelanggan with AJAX Auto Complete -->
      <div class="form-group" style="position:relative;">
        <label class="form-label" style="display:flex; justify-content:space-between; align-items:center;">
          <span>Nama Pelanggan *</span>
          <span style="font-size:11px; font-weight:normal; color:var(--primary); display:inline-flex; align-items:center; gap:4px;">
            ⚡ Auto-complete Data Pelanggan
          </span>
        </label>
        <div style="position:relative;">
          <input type="text" name="nama_pelanggan" id="order_nama_pelanggan" class="form-control" placeholder="Ketik nama atau no HP pelanggan..." autocomplete="off" required>
          <div id="cust_search_spinner" style="display:none; position:absolute; right:12px; top:50%; transform:translateY(-50%); font-size:11px; color:var(--primary); font-weight:600;">
            ⏳ Mencari...
          </div>
        </div>

        <!-- Autocomplete Suggestions Box -->
        <div id="cust_autocomplete_box" style="display:none; position:absolute; top:100%; left:0; right:0; background:var(--bg-card); border:1px solid var(--border-color); border-radius:12px; box-shadow:0 12px 30px rgba(0,0,0,0.18); z-index:10000; max-height:220px; overflow-y:auto; margin-top:4px;">
        </div>
      </div>

      <div class="grid grid-2">
        <div class="form-group">
          <label class="form-label">Nomor WhatsApp / HP</label>
          <input type="text" name="no_hp" id="order_no_hp" class="form-control" placeholder="cth. 081234567890">
        </div>
        <div class="form-group">
          <label class="form-label">Kategori Pekerjaan</label>
          <select name="kategori" class="form-control">
            <option value="">-- Pilih Kategori Pekerjaan --</option>
            @foreach($categories as $cat)
              <option value="{{ $cat->nama }}">{{ $cat->emoji ?: '📂' }} {{ $cat->nama }}</option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Total Nilai Tagihan (Rp) *</label>
        <input type="number" name="total" class="form-control" placeholder="cth. 1500000" min="0" required>
      </div>

      <div class="form-group">
        <label class="form-label">Alamat / Lokasi Pemasangan</label>
        <textarea name="alamat" id="order_alamat" class="form-control" rows="2" placeholder="Alamat lengkap tujuan kirim atau survey lokasi..."></textarea>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
  const inputNama = document.getElementById('order_nama_pelanggan');
  const inputNoHp = document.getElementById('order_no_hp');
  const inputAlamat = document.getElementById('order_alamat');
  const autocompleteBox = document.getElementById('cust_autocomplete_box');
  const spinner = document.getElementById('cust_search_spinner');

  let debounceTimer = null;

  if (inputNama && autocompleteBox) {
    inputNama.addEventListener('input', function() {
      const query = this.value.trim();
      clearTimeout(debounceTimer);

      if (query.length < 2) {
        autocompleteBox.style.display = 'none';
        autocompleteBox.innerHTML = '';
        if (spinner) spinner.style.display = 'none';
        return;
      }

      if (spinner) spinner.style.display = 'block';

      debounceTimer = setTimeout(() => {
        fetch(`{{ route('status_order.search_pelanggan') }}?q=${encodeURIComponent(query)}`, {
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
          }
        })
        .then(res => res.json())
        .then(data => {
          if (spinner) spinner.style.display = 'none';
          if (!data || data.length === 0) {
            autocompleteBox.innerHTML = `
              <div style="padding:12px 16px; font-size:12px; color:var(--text-muted); text-align:center;">
                Tidak ada data pelanggan yang cocok. Anda dapat langsung mengetik nama baru.
              </div>
            `;
            autocompleteBox.style.display = 'block';
            return;
          }

          let html = '';
          data.forEach((item, index) => {
            const isReg = item.type === 'Pelanggan Terdaftar';
            const badgeBg = isReg ? 'rgba(99, 102, 241, 0.15)' : 'rgba(245, 158, 11, 0.15)';
            const badgeColor = isReg ? 'var(--primary)' : 'var(--warning)';

            html += `
              <div class="cust-autocomplete-item" 
                   data-index="${index}" 
                   style="padding:10px 14px; cursor:pointer; border-bottom:1px solid var(--border-color); display:flex; justify-content:space-between; align-items:center; transition:background 0.15s;"
                   onmouseover="this.style.background='var(--bg-hover, rgba(99, 102, 241, 0.08))'"
                   onmouseout="this.style.background='transparent'">
                <div>
                  <div style="font-weight:700; font-size:13px; color:var(--text-main); display:flex; align-items:center; gap:6px;">
                    <span>👤 ${escapeHtml(item.nama)}</span>
                  </div>
                  <div style="font-size:11px; color:var(--text-muted); margin-top:2px; display:flex; gap:10px; flex-wrap:wrap;">
                    ${item.no_hp ? `<span>📞 ${escapeHtml(item.no_hp)}</span>` : ''}
                    ${item.email ? `<span>✉️ ${escapeHtml(item.email)}</span>` : ''}
                    ${item.alamat ? `<span>📍 ${escapeHtml(item.alamat)}</span>` : ''}
                  </div>
                </div>
                <span style="font-size:10px; font-weight:700; padding:2px 8px; border-radius:6px; background:${badgeBg}; color:${badgeColor}; white-space:nowrap;">
                  ${escapeHtml(item.type)}
                </span>
              </div>
            `;
          });

          autocompleteBox.innerHTML = html;
          autocompleteBox.style.display = 'block';

          // Attach click listeners to generated items
          const items = autocompleteBox.querySelectorAll('.cust-autocomplete-item');
          items.forEach(el => {
            el.addEventListener('click', function() {
              const idx = this.getAttribute('data-index');
              const selected = data[idx];
              if (selected) {
                inputNama.value = selected.nama;
                if (selected.no_hp && inputNoHp) {
                  inputNoHp.value = selected.no_hp;
                }
                if (selected.alamat && inputAlamat) {
                  inputAlamat.value = selected.alamat;
                }
              }
              autocompleteBox.style.display = 'none';
            });
          });
        })
        .catch(err => {
          if (spinner) spinner.style.display = 'none';
          console.error('Error fetching customers:', err);
        });
      }, 250);
    });

    // Close suggestions box on outside click
    document.addEventListener('click', function(e) {
      if (!inputNama.contains(e.target) && !autocompleteBox.contains(e.target)) {
        autocompleteBox.style.display = 'none';
      }
    });

    // Close on Escape key
    inputNama.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        autocompleteBox.style.display = 'none';
      }
    });
  }

  function escapeHtml(text) {
    if (!text) return '';
    const map = {
      '&': '&amp;',
      '<': '&lt;',
      '>': '&gt;',
      '"': '&quot;',
      "'": '&#039;'
    };
    return text.toString().replace(/[&<>"']/g, m => map[m]);
  }
});
</script>

@endsection
