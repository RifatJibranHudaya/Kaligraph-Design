@extends('layouts.app')

@section('title', 'Kelola Produk Neon Box')

@section('content')
<div class="grid grid-2">
  <!-- Form Tambah Produk -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">➕ Tambah Produk Neon Box Baru</h3>
    </div>
    <form method="POST" action="{{ route('produk.store') }}" enctype="multipart/form-data">
      @csrf
      <div class="form-group">
        <label class="form-label">Nama Produk *</label>
        <input type="text" name="nama" class="form-control" placeholder="cth. Neon Box Akrilik LED" value="{{ old('nama') }}" required>
      </div>

      <!-- Upload Foto Produk -->
      <div class="form-group">
        <label class="form-label">Foto Produk (JPG, PNG, WEBP max 3MB)</label>
        <input type="file" name="foto" id="fotoInput" class="form-control" accept="image/*" onchange="previewImage(this, 'previewImg')">
        <div id="previewContainer" style="margin-top:10px; display:none;">
          <img id="previewImg" src="#" alt="Preview Foto" style="width:120px; height:120px; object-fit:cover; border-radius:12px; border:2px solid var(--border-color);">
        </div>
      </div>

      <!-- Rentang Harga -->
      <div class="grid grid-2">
        <div class="form-group">
          <label class="form-label">Harga Minimum / Mulai Dari (Rp) *</label>
          <input type="number" name="harga_min" class="form-control" placeholder="cth. 350000" min="0" value="{{ old('harga_min') }}" required>
        </div>
        <div class="form-group">
          <label class="form-label">Harga Maksimum (Rp, Opsional)</label>
          <input type="number" name="harga_max" class="form-control" placeholder="cth. 750000" min="0" value="{{ old('harga_max') }}">
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Deskripsi & Spesifikasi Produk</label>
        <textarea name="deskripsi" class="form-control" rows="3" placeholder="Jelaskan material akrilik, ketebalan, jenis LED, garansi, dll...">{{ old('deskripsi') }}</textarea>
      </div>

      <div class="form-group">
        <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
          <input type="checkbox" name="is_active" value="1" checked> Tampilkan di Website & Katalog
        </label>
      </div>

      <button type="submit" class="btn btn-primary" style="width:100%;">Simpan Produk Baru ➔</button>
    </form>
  </div>

  <!-- Daftar Produk -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">💡 Katalog Produk Signage Aktif</h3>
    </div>
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>Foto</th>
            <th>Nama & Spesifikasi</th>
            <th>Rentang Harga</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($products as $p)
            <tr>
              <td style="width:70px;">
                @if($p->foto_url)
                  <img src="{{ $p->foto_url }}" alt="{{ $p->nama }}" style="width:56px; height:56px; object-fit:cover; border-radius:10px; border:1px solid var(--border-color);">
                @else
                  <div style="width:56px; height:56px; border-radius:10px; background:linear-gradient(135deg, var(--primary-light), #ede9fe); display:flex; align-items:center; justify-content:center; font-size:24px;">
                    💡
                  </div>
                @endif
              </td>
              <td>
                <strong>{{ $p->nama }}</strong>
                <div style="font-size:12px; color:var(--text-muted); line-height:1.4; max-width:260px;">
                  {{ Str::limit($p->deskripsi ?: '-', 60) }}
                </div>
              </td>
              <td>
                <span style="font-weight:800; color:var(--primary); font-size:13px; white-space:nowrap;">
                  {{ $p->harga_display }}
                </span>
              </td>
              <td>
                <form method="POST" action="{{ route('produk.toggle', $p->id) }}">
                  @csrf
                  <button type="submit" class="badge {{ $p->is_active ? 'badge-success' : 'badge-danger' }}" style="border:none; cursor:pointer;" title="Klik untuk ubah status">
                    {{ $p->is_active ? 'Aktif' : 'Non-Aktif' }}
                  </button>
                </form>
              </td>
              <td>
                <div style="display:flex; gap:6px;">
                  <button type="button" class="btn btn-sm btn-secondary" onclick="openEditProductModal({{ $p->id }}, '{{ addslashes($p->nama) }}', {{ $p->harga_min ?: $p->harga_default }}, {{ $p->harga_max ?: 'null' }}, '{{ addslashes($p->deskripsi ?? '') }}', '{{ $p->foto_url ?? '' }}')">
                    ✏️ Edit
                  </button>
                  <form method="POST" action="{{ route('produk.destroy', $p->id) }}" onsubmit="return confirm('Hapus produk {{ $p->nama }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" style="text-align:center; color:var(--text-muted); padding:30px;">
                Belum ada data produk.
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
  <div class="card" style="width:100%; max-width:540px; background:var(--bg-card); margin:0; border-radius:20px; box-shadow:0 25px 50px -12px rgba(0,0,0,0.25); max-height:90vh; overflow-y:auto;">
    <div class="card-header">
      <h3 class="card-title">✏️ Edit Produk Neon Box</h3>
      <button type="button" onclick="closeEditProductModal()" style="background:none; border:none; font-size:20px; cursor:pointer; color:var(--text-main);">✕</button>
    </div>
    <form id="editProductForm" method="POST" action="" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="form-group">
        <label class="form-label">Nama Produk *</label>
        <input type="text" name="nama" id="edit_nama" class="form-control" required>
      </div>

      <div class="form-group">
        <label class="form-label">Ganti Foto Produk (Opsional)</label>
        <input type="file" name="foto" class="form-control" accept="image/*" onchange="previewImage(this, 'edit_previewImg')">
        <div id="edit_previewContainer" style="margin-top:10px;">
          <img id="edit_previewImg" src="" alt="Preview Foto" style="width:100px; height:100px; object-fit:cover; border-radius:12px; border:2px solid var(--border-color); display:none;">
        </div>
      </div>

      <div class="grid grid-2">
        <div class="form-group">
          <label class="form-label">Harga Min / Mulai Dari (Rp) *</label>
          <input type="number" name="harga_min" id="edit_harga_min" class="form-control" min="0" required>
        </div>
        <div class="form-group">
          <label class="form-label">Harga Maksimum (Rp, Opsional)</label>
          <input type="number" name="harga_max" id="edit_harga_max" class="form-control" min="0">
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Deskripsi & Spesifikasi</label>
        <textarea name="deskripsi" id="edit_deskripsi" class="form-control" rows="3"></textarea>
      </div>

      <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:20px;">
        <button type="button" class="btn btn-secondary" onclick="closeEditProductModal()">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Perubahan ➔</button>
      </div>
    </form>
  </div>
</div>

<script>
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

function openEditProductModal(id, nama, hargaMin, hargaMax, deskripsi, fotoUrl) {
  document.getElementById('editProductForm').action = "{{ url('produk') }}/" + id;
  document.getElementById('edit_nama').value = nama;
  document.getElementById('edit_harga_min').value = hargaMin;
  document.getElementById('edit_harga_max').value = (hargaMax && hargaMax !== 'null') ? hargaMax : '';
  document.getElementById('edit_deskripsi').value = deskripsi;

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
</script>
@endsection
