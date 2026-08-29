@extends('layouts.app')

@section('title', 'Kelola Stok Bahan & Produk')

@section('content')
<div class="grid grid-2">
  <!-- Form Catat Stok -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">➕ Catat Pergerakan Stok</h3>
    </div>
    <form method="POST" action="{{ route('stok.store') }}">
      @csrf
      <div class="form-group">
        <label class="form-label">Tanggal Record *</label>
        <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
      </div>

      <div class="form-group">
        <label class="form-label">Tipe Pergerakan *</label>
        <select name="tipe" class="form-control" required>
          <option value="masuk">Masuk (Pembelian/Pasokan)</option>
          <option value="keluar">Keluar (Dipakai/Rusak)</option>
          <option value="opname">Stok Opname</option>
          <option value="retur">Retur Supplier</option>
        </select>
      </div>

      <div class="form-group">
        <label class="form-label">Nama Produk / Bahan *</label>
        <input type="text" name="produk" class="form-control" list="productList" placeholder="cth. Daging Ayam / Minyak Goreng" required>
        <datalist id="productList">
          @foreach($products as $prod)
            <option value="{{ $prod->nama }}">
          @endforeach
        </datalist>
      </div>

      <div class="grid grid-2">
        <div class="form-group">
          <label class="form-label">Jumlah *</label>
          <input type="number" name="jumlah" class="form-control" min="1" placeholder="10" required>
        </div>
        <div class="form-group">
          <label class="form-label">Satuan *</label>
          <input type="text" name="satuan" class="form-control" placeholder="Porsi / Kg / DUS" required>
        </div>
      </div>

      <button type="submit" class="btn btn-primary" style="width:100%;">Catat Stok ➔</button>
    </form>
  </div>

  <!-- Riwayat Stok -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">📦 Riwayat Catatan Stok</h3>
    </div>
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>Tanggal</th>
            <th>Item</th>
            <th>Tipe</th>
            <th>Jumlah</th>
            <th>User</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($stockRecords as $st)
            <tr>
              <td>{{ $st->tanggal ? $st->tanggal->format('d/m/Y') : '-' }}</td>
              <td><strong>{{ $st->produk }}</strong></td>
              <td>
                <span class="badge {{ $st->tipe === 'masuk' ? 'badge-success' : 'badge-danger' }}">
                  {{ strtoupper($st->tipe) }}
                </span>
              </td>
              <td><strong>{{ $st->jumlah }} {{ $st->satuan }}</strong></td>
              <td><span style="font-size:12px;">{{ $st->user ? $st->user->username : '-' }}</span></td>
              <td>
                <form method="POST" action="{{ route('stok.destroy', $st->id) }}" onsubmit="return confirm('Hapus catatan stok ini?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" style="text-align:center; color:var(--text-muted); padding:30px;">
                Belum ada catatan pergerakan stok.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div style="margin-top:14px;">
      {{ $stockRecords->links() }}
    </div>
  </div>
</div>
@endsection
