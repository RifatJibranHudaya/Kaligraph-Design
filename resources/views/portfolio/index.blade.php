@extends('layouts.app')

@section('title', 'Kelola Portofolio')

@section('content')
<div class="grid grid-2">
  <!-- Form Tambah Portofolio -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Tambah Portofolio Baru</h3>
    </div>
    <form method="POST" action="{{ route('portfolio.store') }}" enctype="multipart/form-data">
      @csrf
      <div class="form-group">
        <label class="form-label">Nama Proyek / Karya *</label>
        <input type="text" name="nama" class="form-control" placeholder="cth. Neon Box Warung Kopi XYZ" value="{{ old('nama') }}" required>
      </div>

      <div class="form-group">
        <label class="form-label">Kategori</label>
        <select name="category_id" class="form-control">
          <option value="">-- Pilih Kategori (Opsional) --</option>
          @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
              {{ $cat->emoji ?: '📂' }} {{ $cat->nama }}
            </option>
          @endforeach
        </select>
      </div>

      <!-- Upload Foto -->
      <div class="form-group">
        <label class="form-label">Foto Proyek (JPG, PNG, WEBP max 3MB)</label>
        <input type="file" name="foto" id="fotoInput" class="form-control" accept="image/*" onchange="previewImage(this, 'previewImg')">
        <div id="previewContainer" style="margin-top:10px; display:none;">
          <img id="previewImg" src="#" alt="Preview Foto" style="width:120px; height:120px; object-fit:cover; border-radius:12px; border:2px solid var(--border-color);">
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Nama Klien / Pelanggan</label>
        <input type="text" name="client" class="form-control" placeholder="cth. PT Maju Jaya" value="{{ old('client') }}">
      </div>

      <div class="grid grid-2">
        <div class="form-group">
          <label class="form-label">Lokasi Proyek</label>
          <input type="text" name="lokasi" class="form-control" placeholder="cth. Demak, Jawa Tengah" value="{{ old('lokasi') }}">
        </div>
        <div class="form-group">
          <label class="form-label">Tahun Pengerjaan</label>
          <input type="text" name="tahun" class="form-control" placeholder="cth. 2024" maxlength="10" value="{{ old('tahun') }}">
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Deskripsi Proyek</label>
        <textarea name="deskripsi" class="form-control" rows="3" placeholder="Jelaskan detail proyek, material, ukuran, dll...">{{ old('deskripsi') }}</textarea>
      </div>

      <div class="form-group">
        <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
          <input type="checkbox" name="is_active" value="1" checked> Tampilkan di Website
        </label>
      </div>

      <button type="submit" class="btn btn-primary" style="width:100%;">Simpan Portofolio Baru ➔</button>
    </form>
  </div>

  <!-- Daftar Portofolio -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Daftar Portofolio ({{ $portfolios->count() }})</h3>
    </div>
    <div class="table-responsive">
      <table class="table" id="portfolioTable">
        <thead>
          <tr>
            <th>Foto</th>
            <th>Proyek & Kategori</th>
            <th>Klien</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($portfolios as $p)
            <tr>
              <td style="width:65px;">
                @if($p->foto_url)
                  <img src="{{ $p->foto_url }}" alt="{{ $p->nama }}" style="width:52px; height:52px; object-fit:cover; border-radius:10px; border:1px solid var(--border-color);">
                @else
                  <div style="width:52px; height:52px; border-radius:10px; background:linear-gradient(135deg, var(--primary-light), #ede9fe); display:flex; align-items:center; justify-content:center; font-size:22px;">
                    
                  </div>
                @endif
              </td>
              <td>
                <strong>{{ $p->nama }}</strong>
                @if($p->category)
                  <div style="margin-top:2px;">
                    <span class="badge badge-purple" style="font-size:11px; padding:2px 8px;">
                      {{ $p->category->emoji ?: '📂' }} {{ $p->category->nama }}
                    </span>
                  </div>
                @endif
                @if($p->lokasi || $p->tahun)
                  <div style="font-size:11px; color:var(--text-muted); margin-top:2px;">
                    {{ $p->lokasi }}{{ $p->lokasi && $p->tahun ? ' · ' : '' }}{{ $p->tahun }}
                  </div>
                @endif
              </td>
              <td>
                <span style="font-size:13px; font-weight:600;">{{ $p->client ?: '-' }}</span>
              </td>
              <td>
                <form method="POST" action="{{ route('portfolio.toggle', $p->id) }}">
                  @csrf
                  <button type="submit" class="badge {{ $p->is_active ? 'badge-success' : 'badge-danger' }}" style="border:none; cursor:pointer;" title="Klik untuk ubah status">
                    {{ $p->is_active ? 'Aktif' : 'Non-Aktif' }}
                  </button>
                </form>
              </td>
              <td>
                <div style="display:flex; gap:6px;">
                  <button type="button" class="btn btn-sm btn-secondary" onclick="openEditPortfolioModal({{ $p->id }}, '{{ addslashes($p->nama) }}', '{{ $p->category_id ?? '' }}', '{{ addslashes($p->client ?? '') }}', '{{ addslashes($p->lokasi ?? '') }}', '{{ addslashes($p->tahun ?? '') }}', '{{ addslashes($p->deskripsi ?? '') }}', '{{ $p->foto_url ?? '' }}')">
                    ✏️
                  </button>
                  <form method="POST" action="{{ route('portfolio.destroy', $p->id) }}" onsubmit="return confirm('Hapus portofolio {{ $p->nama }}?')">
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
                Belum ada data portofolio.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Edit Portofolio -->
<div id="editPortfolioModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); z-index:9999; align-items:center; justify-content:center; padding:20px;">
  <div class="card" style="width:100%; max-width:540px; background:var(--bg-card); margin:0; border-radius:20px; box-shadow:0 25px 50px -12px rgba(0,0,0,0.25); max-height:90vh; overflow-y:auto;">
    <div class="card-header">
      <h3 class="card-title">Edit Portofolio</h3>
      <button type="button" onclick="closeEditPortfolioModal()" style="background:none; border:none; font-size:20px; cursor:pointer; color:var(--text-main);">✕</button>
    </div>
    <form id="editPortfolioForm" method="POST" action="" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="form-group">
        <label class="form-label">Nama Proyek / Karya *</label>
        <input type="text" name="nama" id="edit_nama" class="form-control" required>
      </div>

      <div class="form-group">
        <label class="form-label">Kategori</label>
        <select name="category_id" id="edit_category_id" class="form-control">
          <option value="">-- Tanpa Kategori --</option>
          @foreach($categories as $cat)
            <option value="{{ $cat->id }}">
              {{ $cat->emoji ?: '📂' }} {{ $cat->nama }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="form-group">
        <label class="form-label">Ganti Foto Proyek (Opsional)</label>
        <input type="file" name="foto" class="form-control" accept="image/*" onchange="previewImage(this, 'edit_previewImg')">
        <div id="edit_previewContainer" style="margin-top:10px;">
          <img id="edit_previewImg" src="" alt="Preview Foto" style="width:100px; height:100px; object-fit:cover; border-radius:12px; border:2px solid var(--border-color); display:none;">
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Nama Klien / Pelanggan</label>
        <input type="text" name="client" id="edit_client" class="form-control">
      </div>

      <div class="grid grid-2">
        <div class="form-group">
          <label class="form-label">Lokasi Proyek</label>
          <input type="text" name="lokasi" id="edit_lokasi" class="form-control">
        </div>
        <div class="form-group">
          <label class="form-label">Tahun</label>
          <input type="text" name="tahun" id="edit_tahun" class="form-control" maxlength="10">
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Deskripsi Proyek</label>
        <textarea name="deskripsi" id="edit_deskripsi" class="form-control" rows="3"></textarea>
      </div>

      <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:20px;">
        <button type="button" class="btn btn-secondary" onclick="closeEditPortfolioModal()">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Perubahan ➔</button>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
  $('#portfolioTable').DataTable({
    order: [[1, 'asc']],
    pageLength: 10,
    columnDefs: [
      { orderable: false, targets: [0, 3, 4] }
    ]
  });
});

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

function openEditPortfolioModal(id, nama, categoryId, client, lokasi, tahun, deskripsi, fotoUrl) {
  document.getElementById('editPortfolioForm').action = "{{ url('portfolio') }}/" + id;
  document.getElementById('edit_nama').value = nama;
  document.getElementById('edit_category_id').value = categoryId || '';
  document.getElementById('edit_client').value = client;
  document.getElementById('edit_lokasi').value = lokasi;
  document.getElementById('edit_tahun').value = tahun;
  document.getElementById('edit_deskripsi').value = deskripsi;

  const editImg = document.getElementById('edit_previewImg');
  if (fotoUrl) {
    editImg.src = fotoUrl;
    editImg.style.display = 'block';
  } else {
    editImg.style.display = 'none';
  }

  document.getElementById('editPortfolioModal').style.display = 'flex';
}

function closeEditPortfolioModal() {
  document.getElementById('editPortfolioModal').style.display = 'none';
}
</script>
@endsection
