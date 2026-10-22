@extends('layouts.app')

@section('title', 'Kelola Produk & Sub-Modul')

@section('content')
<style>
  .product-submod-tabs {
    display: flex;
    gap: 10px;
    margin-bottom: 24px;
    border-bottom: 2px solid var(--border-color);
    padding-bottom: 8px;
    flex-wrap: wrap;
  }
  .submod-tab-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 18px;
    border-radius: 12px;
    font-weight: 700;
    font-size: 14px;
    text-decoration: none;
    color: var(--text-muted);
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    transition: all 0.2s;
  }
  .submod-tab-btn:hover {
    color: var(--primary);
    border-color: var(--primary-light);
  }
  .submod-tab-btn.active {
    background: var(--primary);
    color: #fff;
    border-color: var(--primary);
    box-shadow: 0 4px 14px rgba(37,99,235,0.25);
  }
  .submod-badge {
    padding: 2px 8px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 800;
    background: rgba(0,0,0,0.08);
  }
  .submod-tab-btn.active .submod-badge {
    background: rgba(255,255,255,0.25);
    color: #fff;
  }
  .badge-custom-wa {
    background: #ecfdf5;
    color: #059669;
    border: 1px solid #a7f3d0;
  }
  .badge-ecommerce {
    background: #eff6ff;
    color: #2563eb;
    border: 1px solid #bfdbfe;
  }
  .type-radio-card {
    border: 2px solid var(--border-color);
    border-radius: 12px;
    padding: 12px 14px;
    cursor: pointer;
    transition: all 0.2s;
    background: var(--bg-card);
  }
  .type-radio-card:hover {
    border-color: #93c5fd;
  }
  .type-radio-card.selected {
    border-color: var(--primary);
    background: #f0f7ff;
  }
</style>

<!-- Sub-Modul Filter Tabs -->
<div class="product-submod-tabs">
  <a href="{{ route('produk.index') }}" class="submod-tab-btn {{ $currentTab === 'semua' ? 'active' : '' }}">
    <span>📋 Semua Produk</span>
    <span class="submod-badge">{{ $counts['semua'] }}</span>
  </a>
  <a href="{{ route('produk.index', ['tab' => 'custom_wa']) }}" class="submod-tab-btn {{ $currentTab === 'custom_wa' ? 'active' : '' }}">
    <span>📱 Sub-Modul: Pesanan Kustom (Hubungi WA)</span>
    <span class="submod-badge">{{ $counts['custom_wa'] }}</span>
  </a>
  <a href="{{ route('produk.index', ['tab' => 'ecommerce']) }}" class="submod-tab-btn {{ $currentTab === 'ecommerce' ? 'active' : '' }}">
    <span>🛒 Sub-Modul: E-Commerce Ready Stock</span>
    <span class="submod-badge">{{ $counts['ecommerce'] }}</span>
  </a>
</div>

<div class="grid grid-2">
  <!-- Form Tambah Produk -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Tambah Produk Baru</h3>
    </div>
    <form method="POST" action="{{ route('produk.store') }}" enctype="multipart/form-data">
      @csrf

      <!-- Pilihan Sub-Modul / Tipe Produk -->
      <div class="form-group">
        <label class="form-label" style="font-weight:700;">Sub-Modul Produk *</label>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-top:4px;">
          <label class="type-radio-card selected" id="radioLabelWa" onclick="selectProductType('custom_wa')">
            <input type="radio" name="tipe_produk" value="custom_wa" id="radioTypeWa" checked style="display:none;">
            <div style="font-weight:700; color:#059669; font-size:13px; display:flex; align-items:center; gap:6px;">
              <span>📱 Pesanan Kustom</span>
            </div>
            <div style="font-size:11px; color:var(--text-muted); margin-top:3px; line-height:1.3;">
              Konsultasi ukuran & pesan via WhatsApp
            </div>
          </label>
          <label class="type-radio-card" id="radioLabelEc" onclick="selectProductType('ecommerce')">
            <input type="radio" name="tipe_produk" value="ecommerce" id="radioTypeEc" style="display:none;">
            <div style="font-weight:700; color:#2563eb; font-size:13px; display:flex; align-items:center; gap:6px;">
              <span>🛒 E-Commerce</span>
            </div>
            <div style="font-size:11px; color:var(--text-muted); margin-top:3px; line-height:1.3;">
              Ready stock, masuk keranjang & checkout
            </div>
          </label>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Nama Produk *</label>
        <input type="text" name="nama" class="form-control" placeholder="cth. Neon Box Akrilik LED Bulat" value="{{ old('nama') }}" required>
      </div>

      <!-- Field Khusus E-Commerce: SKU & Stok -->
      <div id="ecommerceFields" style="display:none; background:#f8fafc; border:1px dashed #cbd5e1; border-radius:12px; padding:12px 14px; margin-bottom:16px;">
        <div class="grid grid-2">
          <div class="form-group" style="margin-bottom:0;">
            <label class="form-label">Kode SKU (Opsional)</label>
            <input type="text" name="sku" class="form-control" placeholder="cth. EC-BOX-01" value="{{ old('sku') }}">
            <small style="color:var(--text-muted); font-size:10.5px;">Otomatis jika dikosongkan</small>
          </div>
          <div class="form-group" style="margin-bottom:0;">
            <label class="form-label">Stok Fisik Tersedia *</label>
            <input type="number" name="stock" class="form-control" placeholder="10" min="0" value="{{ old('stock', 10) }}">
            <small style="color:var(--text-muted); font-size:10.5px;">Berkurang otomatis saat checkout</small>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Kategori Produk</label>
        <select name="category_id" class="form-control">
          <option value="">-- Pilih Kategori (Opsional) --</option>
          @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
              {{ $cat->nama }}
            </option>
          @endforeach
        </select>
      </div>

      <!-- Upload Foto Produk -->
      <div class="form-group">
        <label class="form-label">Foto Produk (JPG, PNG, WEBP max 3MB)</label>
        <input type="file" name="foto" id="fotoInput" class="form-control" accept="image/jpeg,image/png,image/webp" onchange="previewImage(this, 'previewImg')">
        <div id="previewContainer" style="margin-top:10px; display:none;">
          <img id="previewImg" src="#" alt="Preview Foto" style="width:120px; height:120px; object-fit:cover; border-radius:12px; border:2px solid var(--border-color);">
        </div>
      </div>

      <!-- Rentang Harga -->
      <div class="grid grid-2">
        <div class="form-group">
          <label class="form-label" id="labelHargaMin">Harga Jual / Mulai Dari (Rp) *</label>
          <input type="number" name="harga_min" class="form-control" placeholder="cth. 350000" min="0" value="{{ old('harga_min') }}" required>
        </div>
        <div class="form-group" id="groupHargaMax">
          <label class="form-label">Harga Maksimum (Rp, Opsional)</label>
          <input type="number" name="harga_max" class="form-control" placeholder="cth. 750000" min="0" value="{{ old('harga_max') }}">
          <small style="color:var(--text-muted); font-size:10.5px;">Khusus estimasi harga kustom</small>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Deskripsi & Spesifikasi Produk</label>
        <textarea name="deskripsi" class="form-control" rows="3" placeholder="Jelaskan material akrilik, ketebalan, jenis LED, garansi, dimensi, dll...">{{ old('deskripsi') }}</textarea>
      </div>

      <div class="form-group">
        <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
          <input type="checkbox" name="is_active" value="1" checked> Tampilkan di Website & Katalog Publik
        </label>
      </div>

      <button type="submit" class="btn btn-primary" style="width:100%;">Simpan Produk Baru</button>
    </form>
  </div>

  <!-- Daftar Produk -->
  <div class="card">
    <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
      <h3 class="card-title">Daftar Produk ({{ $products->count() }})</h3>
      @if($currentTab === 'ecommerce')
        <span class="badge badge-purple" style="font-size:12px;">Sub-Modul: E-Commerce</span>
      @elseif($currentTab === 'custom_wa')
        <span class="badge badge-success" style="font-size:12px;">Sub-Modul: Pesanan Kustom</span>
      @endif
    </div>
    <div class="table-responsive">
      <table class="table" id="produkTable">
        <thead>
          <tr>
            <th>Foto</th>
            <th>Nama & Sub-Modul</th>
            <th>Harga & Stok</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($products as $p)
            <tr>
              <td style="width:65px;">
                @if($p->foto_url)
                  <img src="{{ $p->foto_url }}" alt="{{ $p->nama }}" style="width:52px; height:52px; object-fit:cover; border-radius:10px; border:1px solid var(--border-color);">
                @else
                  <div style="width:52px; height:52px; border-radius:10px; background:linear-gradient(135deg, var(--primary-light), #ede9fe); display:flex; align-items:center; justify-content:center; font-size:22px; color:var(--primary); font-weight:800;">
                    K
                  </div>
                @endif
              </td>
              <td>
                <div style="font-weight:700; color:var(--text-main); font-size:14px;">{{ $p->nama }}</div>
                <div style="display:flex; gap:6px; align-items:center; margin-top:4px; flex-wrap:wrap;">
                  @if($p->isEcommerce())
                    <span class="badge badge-ecommerce" style="font-size:10px; padding:2px 6px; font-weight:700;">
                      🛒 E-Commerce
                    </span>
                    @if($p->sku)
                      <span style="font-size:10.5px; color:var(--text-muted); font-family:monospace;">{{ $p->sku }}</span>
                    @endif
                  @else
                    <span class="badge badge-custom-wa" style="font-size:10px; padding:2px 6px; font-weight:700;">
                      📱 Hubungi WA
                    </span>
                  @endif

                  @if($p->category)
                    <span class="badge badge-purple" style="font-size:10px; padding:2px 6px;">
                      {{ $p->category->nama }}
                    </span>
                  @endif
                </div>
              </td>
              <td>
                <div style="font-weight:800; color:var(--primary); font-size:13px; white-space:nowrap;">
                  {{ $p->harga_display }}
                </div>
                @if($p->isEcommerce())
                  <div style="margin-top:4px;">
                    @if($p->stock > 0)
                      <span class="badge badge-success" style="font-size:11px; cursor:pointer;" onclick="openStockModal({{ $p->id }}, '{{ addslashes($p->nama) }}', {{ $p->stock }})" title="Klik untuk sesuaikan stok">
                        Stok: {{ $p->stock }} pcs ✎
                      </span>
                    @else
                      <span class="badge badge-danger" style="font-size:11px; cursor:pointer;" onclick="openStockModal({{ $p->id }}, '{{ addslashes($p->nama) }}', {{ $p->stock }})" title="Klik untuk tambah stok">
                        Stok Habis ✎
                      </span>
                    @endif
                  </div>
                @else
                  <div style="font-size:11px; color:var(--text-muted); margin-top:2px;">
                    Custom Order
                  </div>
                @endif
              </td>
              <td>
                <form method="POST" action="{{ route('produk.toggle', $p->id) }}">
                  @csrf
                  <button type="submit" class="badge {{ $p->is_active ? 'badge-success' : 'badge-danger' }}" style="border:none; cursor:pointer;" title="Klik untuk ubah status tampil">
                    {{ $p->is_active ? 'Aktif' : 'Non-Aktif' }}
                  </button>
                </form>
              </td>
              <td>
                <div style="display:flex; gap:6px;">
                  <button type="button" class="btn btn-sm btn-secondary" onclick="openEditProductModal({{ $p->id }}, '{{ addslashes($p->nama) }}', '{{ $p->tipe_produk ?? 'custom_wa' }}', '{{ $p->sku ?? '' }}', {{ $p->stock ?? 0 }}, '{{ $p->category_id ?? '' }}', {{ $p->harga_min ?: $p->harga_default }}, {{ $p->harga_max ?: 'null' }}, '{{ addslashes($p->deskripsi ?? '') }}', '{{ $p->foto_url ?? '' }}')" title="Edit Produk">
                    ✏️
                  </button>
                  <form method="POST" action="{{ route('produk.destroy', $p->id) }}" onsubmit="return confirm('Hapus produk {{ $p->nama }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus Produk">🗑️</button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" style="text-align:center; color:var(--text-muted); padding:30px;">
                Belum ada produk di sub-modul ini.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Edit Produk -->
<div id="editProductModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); z-index:9999; align-items:center; justify-content:center; padding:20px;">
  <div class="card modal-scroll-container" style="width:100%; max-width:560px; background:var(--bg-card); margin:0; border-radius:20px; box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);">
    <div class="card-header" style="margin-bottom:12px; padding-bottom:12px; border-bottom:1px solid var(--border-color);">
      <h3 class="card-title">Edit Produk</h3>
      <button type="button" onclick="closeEditProductModal()" style="background:none; border:none; font-size:20px; cursor:pointer; color:var(--text-main);">✕</button>
    </div>
    <form id="editProductForm" method="POST" action="" enctype="multipart/form-data" style="display:flex; flex-direction:column; flex:1; overflow:hidden;">
      @csrf
      @method('PUT')
      <div class="modal-scroll-body">

        <!-- Sub-modul / Tipe Produk di Modal -->
        <div class="form-group">
          <label class="form-label" style="font-weight:700;">Sub-Modul Produk *</label>
          <select name="tipe_produk" id="edit_tipe_produk" class="form-control" onchange="toggleEditEcommerceFields(this.value)">
            <option value="custom_wa">📱 Sub-Modul 1: Pesanan Kustom (Hubungi WA)</option>
            <option value="ecommerce">🛒 Sub-Modul 2: E-Commerce Ready Stock (Keranjang Belanja)</option>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label">Nama Produk *</label>
          <input type="text" name="nama" id="edit_nama" class="form-control" required>
        </div>

        <!-- Field Khusus E-Commerce Modal -->
        <div id="editEcommerceBox" style="display:none; background:#f8fafc; border:1px dashed #cbd5e1; border-radius:12px; padding:12px; margin-bottom:14px;">
          <div class="grid grid-2">
            <div class="form-group" style="margin-bottom:0;">
              <label class="form-label">Kode SKU</label>
              <input type="text" name="sku" id="edit_sku" class="form-control">
            </div>
            <div class="form-group" style="margin-bottom:0;">
              <label class="form-label">Stok Fisik</label>
              <input type="number" name="stock" id="edit_stock" class="form-control" min="0">
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Kategori Produk</label>
          <select name="category_id" id="edit_category_id" class="form-control">
            <option value="">-- Tanpa Kategori --</option>
            @foreach($categories as $cat)
              <option value="{{ $cat->id }}">
                {{ $cat->nama }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
          <label class="form-label">Ganti Foto Produk (Opsional)</label>
          <input type="file" name="foto" class="form-control" accept="image/jpeg,image/png,image/webp" onchange="previewImage(this, 'edit_previewImg')">
          <div id="edit_previewContainer" style="margin-top:10px;">
            <img id="edit_previewImg" src="" alt="Preview Foto" style="width:100px; height:100px; object-fit:cover; border-radius:12px; border:2px solid var(--border-color); display:none;">
          </div>
        </div>

        <div class="grid grid-2">
          <div class="form-group">
            <label class="form-label" id="editLabelHargaMin">Harga Jual / Mulai Dari (Rp) *</label>
            <input type="number" name="harga_min" id="edit_harga_min" class="form-control" min="0" required>
          </div>
          <div class="form-group" id="editGroupHargaMax">
            <label class="form-label">Harga Maksimum (Rp)</label>
            <input type="number" name="harga_max" id="edit_harga_max" class="form-control" min="0">
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Deskripsi & Spesifikasi</label>
          <textarea name="deskripsi" id="edit_deskripsi" class="form-control" rows="3"></textarea>
        </div>
      </div>

      <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:14px; padding-top:12px; border-top:1px solid var(--border-color);">
        <button type="button" class="btn btn-secondary" onclick="closeEditProductModal()">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Quick Stock Adjustment -->
<div id="stockAdjustModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); z-index:9999; align-items:center; justify-content:center; padding:20px;">
  <div class="card" style="width:100%; max-width:420px; background:var(--bg-card); margin:0; border-radius:20px;">
    <div class="card-header" style="margin-bottom:12px; padding-bottom:12px; border-bottom:1px solid var(--border-color);">
      <h3 class="card-title">Penyesuaian Stok</h3>
      <button type="button" onclick="closeStockModal()" style="background:none; border:none; font-size:20px; cursor:pointer; color:var(--text-main);">✕</button>
    </div>
    <form id="stockAdjustForm" method="POST" action="">
      @csrf
      <p id="stockProductName" style="font-weight:700; font-size:14px; margin-bottom:12px; color:var(--text-main);"></p>
      <div class="form-group">
        <label class="form-label">Jumlah Stok Tersedia *</label>
        <input type="number" name="stock" id="modalStockInput" class="form-control" min="0" required style="font-size:18px; font-weight:700;">
      </div>
      <div class="form-group">
        <label class="form-label">Keterangan / Alasan (Opsional)</label>
        <input type="text" name="reason" class="form-control" placeholder="cth. Restock dari gudang / koreksi opname">
      </div>
      <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:16px;">
        <button type="button" class="btn btn-secondary" onclick="closeStockModal()">Batal</button>
        <button type="submit" class="btn btn-primary">Update Stok</button>
      </div>
    </form>
  </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
  $('#produkTable').DataTable({
    order: [[1, 'asc']],
    pageLength: 10,
    columnDefs: [
      { orderable: false, targets: [0, 3, 4] }
    ]
  });
});

function selectProductType(type) {
  const isEc = (type === 'ecommerce');
  document.getElementById('radioTypeWa').checked = !isEc;
  document.getElementById('radioTypeEc').checked = isEc;

  document.getElementById('radioLabelWa').classList.toggle('selected', !isEc);
  document.getElementById('radioLabelEc').classList.toggle('selected', isEc);

  document.getElementById('ecommerceFields').style.display = isEc ? 'block' : 'none';
  document.getElementById('groupHargaMax').style.display = isEc ? 'none' : 'block';
  document.getElementById('labelHargaMin').innerText = isEc ? 'Harga Jual Satuan (Rp) *' : 'Harga Minimum / Mulai Dari (Rp) *';
}

function toggleEditEcommerceFields(type) {
  const isEc = (type === 'ecommerce');
  document.getElementById('editEcommerceBox').style.display = isEc ? 'block' : 'none';
  document.getElementById('editGroupHargaMax').style.display = isEc ? 'none' : 'block';
  document.getElementById('editLabelHargaMin').innerText = isEc ? 'Harga Jual Satuan (Rp) *' : 'Harga Minimum / Mulai Dari (Rp) *';
}

function previewImage(input, targetImgId) {
  const file = input.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      const img = document.getElementById(targetImgId);
      img.src = e.target.result;
      img.style.display = 'block';
      if (input.id === 'fotoInput') {
        document.getElementById('previewContainer').style.display = 'block';
      }
    }
    reader.readAsDataURL(file);
  }
}

function openEditProductModal(id, nama, tipeProduk, sku, stock, categoryId, hargaMin, hargaMax, deskripsi, fotoUrl) {
  document.getElementById('editProductForm').action = "{{ url('produk') }}/" + id;
  document.getElementById('edit_nama').value = nama;
  document.getElementById('edit_tipe_produk').value = tipeProduk || 'custom_wa';
  document.getElementById('edit_sku').value = sku || '';
  document.getElementById('edit_stock').value = stock || 0;
  document.getElementById('edit_category_id').value = categoryId || '';
  document.getElementById('edit_harga_min').value = hargaMin;
  document.getElementById('edit_harga_max').value = (hargaMax && hargaMax !== 'null') ? hargaMax : '';
  document.getElementById('edit_deskripsi').value = deskripsi;

  toggleEditEcommerceFields(tipeProduk || 'custom_wa');

  const editImg = document.getElementById('edit_previewImg');
  if (fotoUrl) {
    editImg.src = fotoUrl;
    editImg.style.display = 'block';
  } else {
    editImg.style.display = 'none';
  }

  document.getElementById('editProductModal').style.display = 'flex';
}

function closeEditProductModal() {
  document.getElementById('editProductModal').style.display = 'none';
}

function openStockModal(productId, productName, currentStock) {
  document.getElementById('stockAdjustForm').action = "{{ url('produk') }}/" + productId + "/adjust-stock";
  document.getElementById('stockProductName').innerText = productName;
  document.getElementById('modalStockInput').value = currentStock;
  document.getElementById('stockAdjustModal').style.display = 'flex';
}

function closeStockModal() {
  document.getElementById('stockAdjustModal').style.display = 'none';
}
</script>
@endsection
