@extends('layouts.app')

@section('title', 'Biaya Operasional & Peralatan')

@section('content')
<div class="grid grid-2">
  <!-- Form Input Operasional -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">➕ Catat Biaya / Alat Operasional</h3>
    </div>
    <form method="POST" action="{{ route('operasional.store') }}">
      @csrf
      <div class="form-group">
        <label class="form-label">Nama Alat / Perlengkapan *</label>
        <input type="text" name="nama_alat" class="form-control" placeholder="cth. Kompor Gas High-Pressure 2-Burner" required>
      </div>

      <div class="grid grid-2">
        <div class="form-group">
          <label class="form-label">Harga Pembelian (Rp) *</label>
          <input type="number" name="harga" class="form-control" placeholder="750000" min="0" required>
        </div>
        <div class="form-group">
          <label class="form-label">Tanggal Beli *</label>
          <input type="date" name="tanggal_beli" class="form-control" value="{{ date('Y-m-d') }}" required>
        </div>
      </div>

      <div class="grid grid-3">
        <div class="form-group">
          <label class="form-label">Merk / Brand</label>
          <input type="text" name="merk" class="form-control" placeholder="Rinnai">
        </div>
        <div class="form-group">
          <label class="form-label">Tempat Beli</label>
          <input type="text" name="tempat_beli" class="form-control" placeholder="Toko Elektronik A">
        </div>
        <div class="form-group">
          <label class="form-label">Periode Ganti (Bulan)</label>
          <input type="number" name="periode_ganti" class="form-control" placeholder="12" min="0">
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Keterangan Tambahan</label>
        <textarea name="keterangan" class="form-control" rows="2" placeholder="Garansi, garansi servis, dsb..."></textarea>
      </div>

      <button type="submit" class="btn btn-primary" style="width:100%;">Simpan Data Operasional ➔</button>
    </form>
  </div>

  <!-- Daftar Operasional -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">🛠️ Daftar Peralatan & Operasional</h3>
      <div class="badge badge-danger">Total Biaya: Rp {{ number_format($totalBiaya, 0, ',', '.') }}</div>
    </div>

    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>Tgl Beli</th>
            <th>Nama Alat</th>
            <th>Merk / Toko</th>
            <th>Harga</th>
            <th>Periode Ganti</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($operationals as $op)
            <tr>
              <td>{{ $op->tanggal_beli ? $op->tanggal_beli->format('d/m/Y') : '-' }}</td>
              <td>
                <strong>{{ $op->nama_alat }}</strong>
                @if($op->keterangan)
                  <div style="font-size:11px; color:var(--text-muted);">{{ $op->keterangan }}</div>
                @endif
              </td>
              <td>
                <span style="font-size:12px;">{{ $op->merk ?: '-' }} ({{ $op->tempat_beli ?: '-' }})</span>
              </td>
              <td><strong style="color:var(--danger);">Rp {{ number_format($op->harga, 0, ',', '.') }}</strong></td>
              <td>{{ $op->periode_ganti ? $op->periode_ganti . ' Bulan' : '-' }}</td>
              <td>
                <form method="POST" action="{{ route('operasional.destroy', $op->id) }}" onsubmit="return confirm('Hapus data operasional ini?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" style="text-align:center; color:var(--text-muted); padding:30px;">
                Belum ada data biaya operasional.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div style="margin-top:14px;">
      {{ $operationals->links() }}
    </div>
  </div>
</div>
@endsection
