@extends('layouts.app')

@section('title', 'Manajemen Lokasi & Cabang Showroom')

@section('content')
<div class="grid grid-2">
  <!-- Form Tambah Cabang -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">🏢 Tambah Cabang / Showroom Baru</h3>
    </div>
    <form method="POST" action="{{ route('branches.store') }}">
      @csrf
      <div class="form-group">
        <label class="form-label">Nama Cabang / Showroom *</label>
        <input type="text" name="nama_cabang" class="form-control" placeholder="cth. Showroom Pusat Jakarta" value="{{ old('nama_cabang') }}" required>
      </div>

      <div class="form-group">
        <label class="form-label">Alamat Lengkap</label>
        <textarea name="alamat" class="form-control" rows="2" placeholder="Jl. Raya Utama No. 123, Jakarta Selatan...">{{ old('alamat') }}</textarea>
      </div>

      <div class="form-group">
        <label class="form-label">Embed HTML Google Maps (Iframe) / URL Peta</label>
        <textarea name="map_iframe" class="form-control" rows="3" placeholder='Tempelkan kode <iframe> dari Google Maps di sini, contoh:&#10;<iframe src="https://www.google.com/maps/embed?..." width="600" height="450" ...></iframe>'>{{ old('map_iframe') }}</textarea>
        <small style="color:var(--text-muted); font-size:12px; display:block; margin-top:4px;">
          💡 <strong>Tips Google Maps:</strong> Buka lokasi di Google Maps ➔ Klik "Bagikan" (Share) ➔ Pilih tab "Sematkan peta" (Embed a map) ➔ Salin kode HTML iframe dan tempel di sini.
        </small>
      </div>

      <button type="submit" class="btn btn-primary" style="width:100%;">Simpan Lokasi Cabang ➔</button>
    </form>
  </div>

  <!-- Daftar Cabang -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">📍 Daftar Gerai & Showroom Aktif</h3>
    </div>
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>Cabang & Peta</th>
            <th>Alamat</th>
            <th>Staf</th>
            <th>Order</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($branches as $b)
            <tr>
              <td>
                <strong>{{ $b->nama_cabang }}</strong>
                @if($b->map_iframe || $b->map_url)
                  <div style="margin-top:4px;">
                    <span class="badge badge-primary" style="font-size:11px;">🗺️ Iframe Aktif</span>
                  </div>
                @else
                  <div style="font-size:11px; color:var(--text-muted); margin-top:2px;">Belum ada peta</div>
                @endif
              </td>
              <td><span style="font-size:13px;">{{ $b->alamat ?: '-' }}</span></td>
              <td><span class="badge badge-primary">{{ $b->users_count }} Staf</span></td>
              <td><span class="badge badge-success">{{ $b->orders_count }} Order</span></td>
              <td>
                <div style="display:flex; gap:6px;">
                  <button type="button" class="btn btn-sm btn-secondary" onclick="openEditModal({{ $b->id }}, '{{ addslashes($b->nama_cabang) }}', '{{ addslashes($b->alamat ?? '') }}', `{{ addslashes($b->map_iframe ?? '') }}`)">
                    ✏️ Edit
                  </button>
                  <form method="POST" action="{{ route('branches.destroy', $b->id) }}" onsubmit="return confirm('Hapus cabang {{ $b->nama_cabang }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                  </form>
                </div>
              </td>
            </tr>
            @if($b->clean_iframe)
              <tr>
                <td colspan="5" style="background:var(--bg-main); padding:12px 16px;">
                  <div style="font-size:12px; font-weight:700; color:var(--text-muted); margin-bottom:6px;">Preview Peta Iframe:</div>
                  <div style="max-width:100%; overflow:hidden; border-radius:10px; max-height:180px;">
                    {!! $b->clean_iframe !!}
                  </div>
                </td>
              </tr>
            @endif
          @empty
            <tr>
              <td colspan="5" style="text-align:center; color:var(--text-muted); padding:30px;">
                Belum ada cabang toko terdaftar.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Edit Cabang -->
<div id="editBranchModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); z-index:9999; align-items:center; justify-content:center; padding:20px;">
  <div class="card" style="width:100%; max-width:520px; background:var(--bg-card); margin:0; border-radius:20px; box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);">
    <div class="card-header">
      <h3 class="card-title">✏️ Edit Cabang / Showroom</h3>
      <button type="button" onclick="closeEditModal()" style="background:none; border:none; font-size:20px; cursor:pointer; color:var(--text-main);">✕</button>
    </div>
    <form id="editBranchForm" method="POST" action="">
      @csrf
      @method('PUT')
      <div class="form-group">
        <label class="form-label">Nama Cabang / Showroom *</label>
        <input type="text" name="nama_cabang" id="edit_nama_cabang" class="form-control" required>
      </div>

      <div class="form-group">
        <label class="form-label">Alamat Lengkap</label>
        <textarea name="alamat" id="edit_alamat" class="form-control" rows="2"></textarea>
      </div>

      <div class="form-group">
        <label class="form-label">Embed HTML Google Maps (Iframe)</label>
        <textarea name="map_iframe" id="edit_map_iframe" class="form-control" rows="3" placeholder='<iframe src="https://www.google.com/maps/embed?..." ...></iframe>'></textarea>
      </div>

      <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:20px;">
        <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Perubahan ➔</button>
      </div>
    </form>
  </div>
</div>

<script>
function openEditModal(id, nama, alamat, iframe) {
  document.getElementById('editBranchForm').action = "{{ url('branches') }}/" + id;
  document.getElementById('edit_nama_cabang').value = nama;
  document.getElementById('edit_alamat').value = alamat;
  document.getElementById('edit_map_iframe').value = iframe;
  document.getElementById('editBranchModal').style.display = 'flex';
}

function closeEditModal() {
  document.getElementById('editBranchModal').style.display = 'none';
}
</script>
@endsection
