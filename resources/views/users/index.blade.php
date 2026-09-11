@extends('layouts.app')

@section('title', 'Manajemen Pengguna & Staf')

@section('content')
<!-- Sub-Navigation Header -->
<div style="display:flex; gap:10px; margin-bottom:20px; flex-wrap:wrap;">
  <a href="{{ route('users.index') }}" class="btn btn-primary" style="font-weight:700;">
    Admin & Staf
  </a>
  <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary" style="font-weight:700;">
    Data Pelanggan
  </a>
  <a href="{{ route('akses.index') }}" class="btn btn-secondary" style="font-weight:700;">
    Hak Akses Admin & Staf
  </a>
  <a href="{{ route('akses.pelanggan') }}" class="btn btn-secondary" style="font-weight:700;">
    Hak Akses Level Pelanggan
  </a>
</div>

<div class="grid grid-2">
  <!-- Form Tambah User -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Tambah Pengguna Baru</h3>
    </div>
    <form method="POST" action="{{ route('users.store') }}">
      @csrf
      <div class="form-group">
        <label class="form-label">Username *</label>
        <input type="text" name="username" class="form-control" placeholder="cth. kasir_budi" required>
      </div>

      <div class="grid grid-2">
        <div class="form-group">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" placeholder="budi@dapurku.com">
        </div>
        <div class="form-group">
          <label class="form-label">No. Telepon / WA</label>
          <input type="text" name="phone" class="form-control" placeholder="08123456789">
        </div>
      </div>

      <div class="grid grid-2">
        <div class="form-group">
          <label class="form-label">Role Level *</label>
          <select name="level" class="form-control" required>
            <option value="kasir">Kasir</option>
            <option value="admin">Admin Multi-Modul</option>
            <option value="owner">Owner / Manajer</option>
            <option value="superadmin">Superadmin System</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Cabang Penugasan</label>
          <select name="branch_id" class="form-control">
            <option value="">Semua Cabang / Bebas</option>
            @foreach($branches as $b)
              <option value="{{ $b->id }}">{{ $b->nama_cabang }}</option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Password Akses *</label>
        <input type="password" name="password" class="form-control" minlength="6" placeholder="Minimal 6 karakter" required>
      </div>

      <button type="submit" class="btn btn-primary" style="width:100%;">Tambah User Baru ➔</button>
    </form>
  </div>

  <!-- Daftar Users -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Daftar Pengguna Terdaftar</h3>
    </div>
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>User</th>
            <th>Role Level</th>
            <th>Cabang</th>
            <th>Tgl Daftar</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($users as $u)
            <tr>
              <td>
                <strong>{{ $u->username }}</strong>
                @if($u->email)
                  <div style="font-size:11px; color:var(--text-muted);">{{ $u->email }}</div>
                @endif
              </td>
              <td>
                <span class="badge {{ \App\Helpers\FormatHelper::levelBadgeClass($u->level) }}">
                  {{ strtoupper($u->level) }}
                </span>
              </td>
              <td>
                <span style="font-size:12px;">{{ $u->branch ? $u->branch->nama_cabang : 'Semua Cabang' }}</span>
              </td>
              <td>{{ $u->created_at ? $u->created_at->format('d/m/Y') : '-' }}</td>
              <td>
                @if($u->id !== auth()->id())
                  <form method="POST" action="{{ route('users.destroy', $u->id) }}" onsubmit="return confirm('Hapus pengguna {{ $u->username }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                  </form>
                @else
                  <span style="font-size:11px; color:var(--text-muted);">(Akun Anda)</span>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" style="text-align:center; color:var(--text-muted); padding:30px;">
                Belum ada data user.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div style="margin-top:14px;">
      {{ $users->links() }}
    </div>
  </div>
</div>
@endsection
