@extends('layouts.app')

@section('title', 'Kelola Kategori Produk')

@section('content')
<div class="grid grid-2">
  <!-- Form Tambah Kategori -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Tambah Kategori Baru</h3>
    </div>
    <form method="POST" action="{{ route('kategori.store') }}" enctype="multipart/form-data">
      @csrf
      <div class="form-group">
        <label class="form-label">Nama Kategori *</label>
        <input type="text" name="nama" class="form-control" placeholder="cth. Neon Box Akrilik & LED" value="{{ old('nama') }}" required>
      </div>

      <div class="grid grid-2">
        <div class="form-group">
          <label class="form-label">Emoji / Ikon</label>
          <input type="text" name="emoji" class="form-control" placeholder="cth. 💡 atau 🔤" value="{{ old('emoji') }}">
        </div>
        <div class="form-group">
          <label class="form-label">Nomor Urutan</label>
          <input type="number" name="urutan" class="form-control" placeholder="cth. 1" value="{{ old('urutan') }}">
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Foto / Cover Kategori (Opsional)</label>
        <input type="file" name="foto" id="catFotoInput" class="form-control" accept="image/*" onchange="previewCatImage(this, 'catPreviewImg')">
        <div id="catPreviewContainer" style="margin-top:10px; display:none;">
          <img id="catPreviewImg" src="#" alt="Preview" style="width:120px; height:120px; object-fit:cover; border-radius:12px; border:2px solid var(--border-color);">
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Deskripsi Singkat</label>
        <textarea name="deskripsi" class="form-control" rows="3" placeholder="Penjelasan singkat mengenai kategori produk ini...">{{ old('deskripsi') }}</textarea>
      </div>

      <div class="form-group">
        <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
          <input type="checkbox" name="is_active" value="1" checked> Aktif & Tampilkan di Katalog
        </label>
      </div>

      <button type="submit" class="btn btn-primary" style="width:100%;">Simpan Kategori ➔</button>
    </form>
  </div>

  <!-- Daftar Kategori -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Daftar Kategori ({{ $categories->count() }})</h3>
    </div>
    <div class="table-responsive">
      <table class="table" id="kategoriTable">
        <thead>
          <tr>
            <th>Ikon</th>
            <th>Nama & Slug</th>
            <th>Jumlah Produk</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($categories as $cat)
            <tr>
              <td style="width:60px;">
                @if($cat->foto_url)
                  <img src="{{ $cat->foto_url }}" alt="{{ $cat->nama }}" style="width:48px; height:48px; object-fit:cover; border-radius:10px; border:1px solid var(--border-color);">
                @else
                  <div style="width:48px; height:48px; border-radius:10px; background:var(--primary-light); display:flex; align-items:center; justify-content:center; font-size:22px;">
                    {{ $cat->emoji ?: '📂' }}
                  </div>
                @endif
              </td>
              <td>
                <strong>{{ $cat->nama }}</strong>
                <div style="font-size:11px; color:var(--text-muted); font-family:monospace;">
                  /katalog/{{ $cat->slug }}
                </div>
              </td>
              <td>
                <span class="badge badge-primary">
                  {{ $cat->products_count }} Produk
                </span>
              </td>
              <td>
                <form method="POST" action="{{ route('kategori.toggle', $cat->id) }}">
                  @csrf
                  <button type="submit" class="badge {{ $cat->is_active ? 'badge-success' : 'badge-danger' }}" style="border:none; cursor:pointer;" title="Klik untuk toggle status">
                    {{ $cat->is_active ? 'Aktif' : 'Non-Aktif' }}
                  </button>
                </form>
              </td>
              <td>
                <div style="display:flex; gap:6px;">
                  <button type="button" class="btn btn-sm btn-secondary" onclick="openEditCatModal({{ $cat->id }}, '{{ addslashes($cat->nama) }}', '{{ addslashes($cat->emoji ?? '') }}', {{ $cat->urutan ?? 0 }}, '{{ addslashes($cat->deskripsi ?? '') }}', '{{ $cat->foto_url ?? '' }}', {{ $cat->is_active ? 'true' : 'false' }})">
                    ✏️
                  </button>
                  <form method="POST" action="{{ route('kategori.destroy', $cat->id) }}" onsubmit="return confirm('Hapus kategori {{ $cat->nama }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">🗑️</button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" style="text-align:center; color:var(--text-muted); padding:30px;">
                Belum ada data kategori.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Edit Kategori -->
<div id="editCatModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); z-index:9999; align-items:center; justify-content:center; padding:20px;">
  <div class="card" style="width:100%; max-width:500px; background:var(--bg-card); margin:0; border-radius:20px; box-shadow:0 25px 50px -12px rgba(0,0,0,0.25); max-height:90vh; overflow-y:auto;">
    <div class="card-header">
      <h3 class="card-title">✏️ Edit Kategori</h3>
      <button type="button" onclick="closeEditCatModal()" style="background:none; border:none; font-size:20px; cursor:pointer; color:var(--text-main);">✕</button>
    </div>
    <form id="editCatForm" method="POST" action="" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="form-group">
        <label class="form-label">Nama Kategori *</label>
        <input type="text" name="nama" id="edit_cat_nama" class="form-control" required>
      </div>

      <div class="grid grid-2">
        <div class="form-group">
          <label class="form-label">Emoji / Ikon</label>
          <input type="text" name="emoji" id="edit_cat_emoji" class="form-control">
        </div>
        <div class="form-group">
          <label class="form-label">Nomor Urutan</label>
          <input type="number" name="urutan" id="edit_cat_urutan" class="form-control">
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Ganti Foto / Cover Kategori</label>
        <input type="file" name="foto" class="form-control" accept="image/*" onchange="previewCatImage(this, 'edit_cat_previewImg')">
        <div id="edit_cat_previewContainer" style="margin-top:10px;">
          <img id="edit_cat_previewImg" src="" alt="Preview Foto" style="width:100px; height:100px; object-fit:cover; border-radius:12px; border:2px solid var(--border-color); display:none;">
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Deskripsi</label>
        <textarea name="deskripsi" id="edit_cat_deskripsi" class="form-control" rows="3"></textarea>
      </div>

      <div class="form-group">
        <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
          <input type="checkbox" name="is_active" id="edit_cat_is_active" value="1"> Aktif & Tampilkan di Katalog
        </label>
      </div>

      <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:20px;">
        <button type="button" class="btn btn-secondary" onclick="closeEditCatModal()">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
  $('#kategoriTable').DataTable({
    order: [[1, 'asc']],
    pageLength: 10,
    columnDefs: [
      { orderable: false, targets: [0, 3, 4] }
    ]
  });
});

function previewCatImage(input, targetImgId) {
  const file = input.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      const img = document.getElementById(targetImgId);
      img.src = e.target.result;
      img.style.display = 'block';
      if (input.id === 'catFotoInput') {
        document.getElementById('catPreviewContainer').style.display = 'block';
      }
    }
    reader.readAsDataURL(file);
  }
}

function openEditCatModal(id, nama, emoji, urutan, deskripsi, fotoUrl, isActive) {
  document.getElementById('editCatForm').action = "{{ url('kategori') }}/" + id;
  document.getElementById('edit_cat_nama').value = nama;
  document.getElementById('edit_cat_emoji').value = emoji;
  document.getElementById('edit_cat_urutan').value = urutan;
  document.getElementById('edit_cat_deskripsi').value = deskripsi;
  document.getElementById('edit_cat_is_active').checked = isActive;

  const editImg = document.getElementById('edit_cat_previewImg');
  if (fotoUrl) {
    editImg.src = fotoUrl;
    editImg.style.display = 'block';
  } else {
    editImg.style.display = 'none';
  }

  document.getElementById('editCatModal').style.display = 'flex';
}

function closeEditCatModal() {
  document.getElementById('editCatModal').style.display = 'none';
}
</script>
@endsection
