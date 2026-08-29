@extends('layouts.app')

@section('title', 'Catatan Produksi')

@section('content')
<div class="grid grid-2">
  <!-- Form Catat Produksi -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">➕ Catat Biaya Produksi</h3>
    </div>
    <form method="POST" action="{{ route('produksi.store') }}">
      @csrf
      <div class="form-group">
        <label class="form-label">Nama Item / Bahan Produksi *</label>
        <input type="text" name="nama_item" class="form-control" placeholder="cth. Daging Sapi Lulur 10kg" required>
      </div>

      <div class="grid grid-2">
        <div class="form-group">
          <label class="form-label">Total Biaya (Rp) *</label>
          <input type="number" name="harga" class="form-control" placeholder="150000" min="0" required>
        </div>
        <div class="form-group">
          <label class="form-label">Tanggal *</label>
          <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
        </div>
      </div>

      <div class="grid grid-2">
        <div class="form-group">
          <label class="form-label">Supplier (Opsional)</label>
          <input type="text" name="supplier" class="form-control" placeholder="cth. Toko Segar Berkah">
        </div>
        <div class="form-group">
          <label class="form-label">Tempat Pembelian (Opsional)</label>
          <input type="text" name="tempat" class="form-control" placeholder="cth. Pasar Induk">
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Keterangan Catatan</label>
        <textarea name="keterangan" class="form-control" rows="2" placeholder="Catatan tambahan..."></textarea>
      </div>

      <button type="submit" class="btn btn-primary" style="width:100%;">Simpan Catatan Produksi ➔</button>
    </form>
  </div>

  <!-- Table Produksi -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">🍲 Daftar Catatan Produksi</h3>
      <div class="badge badge-primary">Total: Rp {{ number_format($totalBiaya, 0, ',', '.') }}</div>
    </div>

    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>Tanggal</th>
            <th>Item</th>
            <th>Biaya</th>
            <th>Supplier</th>
            <th>Editor Track</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($productions as $p)
            <tr>
              <td>{{ $p->tanggal ? $p->tanggal->format('d/m/Y') : '-' }}</td>
              <td>
                <strong>{{ $p->nama_item }}</strong>
                @if($p->keterangan)
                  <div style="font-size:11px; color:var(--text-muted);">{{ $p->keterangan }}</div>
                @endif
              </td>
              <td><strong style="color:var(--danger);">Rp {{ number_format($p->harga, 0, ',', '.') }}</strong></td>
              <td><span style="font-size:12px;">{{ $p->supplier ?: '-' }}</span></td>
              <td>
                <span style="font-size:11px; color:var(--text-muted);">
                  By: {{ $p->user ? $p->user->username : '-' }}
                  @if($p->edited_by)
                    <br><i style="color:var(--warning);">Edit: {{ $p->editor ? $p->editor->username : '-' }}</i>
                  @endif
                </span>
              </td>
              <td>
                <form method="POST" action="{{ route('produksi.destroy', $p->id) }}" onsubmit="return confirm('Hapus data produksi ini?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" style="text-align:center; color:var(--text-muted); padding:30px;">
                Belum ada catatan produksi.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div style="margin-top:14px;">
      {{ $productions->links() }}
    </div>
  </div>
</div>
@endsection
