@extends('layouts.app')

@section('title', 'Kelola Landing Page')

@section('content')
<div class="grid grid-2">
  <!-- Form Tambah Section Landing Page -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Tambah / Edit Konten Section</h3>
    </div>
    <form method="POST" action="{{ route('home_manager.store') }}">
      @csrf
      <div class="form-group">
        <label class="form-label">Kategori Section *</label>
        <select name="section" class="form-control" required>
          <option value="hero">Hero Section Utama</option>
          <option value="about">Tentang Restoran (About)</option>
          <option value="features">Fitur Keunggulan</option>
          <option value="contact">Kontak & Medsos</option>
        </select>
      </div>

      <div class="form-group">
        <label class="form-label">Judul Utama (Title)</label>
        <input type="text" name="title" class="form-control" placeholder="cth. Nikmati Hidangan Autentik">
      </div>

      <div class="form-group">
        <label class="form-label">Sub Judul (Subtitle)</label>
        <input type="text" name="subtitle" class="form-control" placeholder="cth. Restoran & Catering Modern">
      </div>

      <div class="form-group">
        <label class="form-label">Deskripsi Lengkap / Isi</label>
        <textarea name="content" class="form-control" rows="3" placeholder="Isi deskripsi konten..."></textarea>
      </div>

      <div class="form-group">
        <label class="form-label">Urutan Tampil</label>
        <input type="number" name="order_index" class="form-control" placeholder="1" min="1">
      </div>

      <div class="form-group">
        <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
          <input type="checkbox" name="is_active" value="1" checked> Tampilkan di Landing Page Publik
        </label>
      </div>

      <button type="submit" class="btn btn-primary" style="width:100%;">Simpan Konten Section ➔</button>
    </form>
  </div>

  <!-- Daftar Konten Section -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Daftar Section Landing Page</h3>
    </div>

    @forelse($sections as $secName => $items)
      <div style="margin-bottom: 20px; border: 1px solid var(--border-color); border-radius: 8px; padding: 14px;">
        <h4 style="font-size:14px; font-weight:700; text-transform:uppercase; color:var(--primary); margin-bottom:10px;">
          Section: {{ $secName }}
        </h4>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>Icon</th>
                <th>Judul & Isi</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($items as $item)
                <tr>
                  <td style="font-size:24px;">{{ $item->icon ?: '📌' }}</td>
                  <td>
                    <strong>{{ $item->title ?: '-' }}</strong>
                    <div style="font-size:12px; color:var(--text-muted);">{{ $item->subtitle }}</div>
                    <div style="font-size:11px; color:var(--text-muted); margin-top:2px;">{{ Str::limit($item->content, 60) }}</div>
                  </td>
                  <td>
                    <form method="POST" action="{{ route('home_manager.toggle', $item->id) }}">
                      @csrf
                      <button type="submit" class="badge {{ $item->is_active ? 'badge-success' : 'badge-danger' }}" style="border:none; cursor:pointer;">
                        {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                      </button>
                    </form>
                  </td>
                  <td>
                    <form method="POST" action="{{ route('home_manager.destroy', $item->id) }}" onsubmit="return confirm('Hapus konten section ini?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    @empty
      <div style="text-align:center; color:var(--text-muted); padding:30px;">
        Belum ada konten section terdaftar.
      </div>
    @endforelse
  </div>
</div>
@endsection
