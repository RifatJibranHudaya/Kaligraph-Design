@extends('layouts.app')

@section('title', 'Hak Akses Admin & Staf')

@section('content')
<!-- Sub-Navigation Header -->
<div style="display:flex; gap:10px; margin-bottom:20px; flex-wrap:wrap;">
  <a href="{{ route('users.index') }}" class="btn btn-secondary" style="font-weight:700;">
    Admin & Staf
  </a>
  <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary" style="font-weight:700;">
    Data Pelanggan
  </a>
  <a href="{{ route('akses.index') }}" class="btn btn-primary" style="font-weight:700;">
    Hak Akses Admin & Staf
  </a>
  <a href="{{ route('akses.pelanggan') }}" class="btn btn-secondary" style="font-weight:700;">
    Hak Akses Level Pelanggan
  </a>
</div>

<div class="card">
  <div class="card-header">
    <div>
      <h3 class="card-title">Pengaturan Hak Akses Admin & Staf (Permissions Matrix)</h3>
      <div style="font-size:12px; color:var(--text-muted); margin-top:2px;">
        Konfigurasi hak akses modul operasional, kasir, katalog produk, dan data transaksi untuk setiap akun staf.
      </div>
    </div>
  </div>

  @if($staffUsers->isEmpty())
    <div style="text-align:center; color:var(--text-muted); padding:40px;">
      Tidak ada akun staf / admin selain Superadmin untuk dikonfigurasi hak aksesnya.
    </div>
  @else
    @foreach($staffUsers as $user)
      <div style="border:1px solid var(--border-color); border-radius:14px; padding:20px; margin-bottom:24px; background:var(--bg-main);">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; flex-wrap:wrap; gap:10px;">
          <div style="display:flex; align-items:center; gap:12px;">
            <div style="width:40px; height:40px; border-radius:10px; background:linear-gradient(135deg, #2563eb, #7c3aed); color:#fff; display:flex; align-items:center; justify-content:center; font-weight:800;">
              {{ strtoupper(substr($user->username, 0, 1)) }}
            </div>
            <div>
              <h4 style="font-size:16px; font-weight:700; margin:0;">{{ $user->username }}</h4>
              <div style="font-size:12px; color:var(--text-muted);">{{ $user->email ?: 'Tanpa email' }}</div>
            </div>
          </div>
          <div>
            <span class="badge {{ \App\Helpers\FormatHelper::levelBadgeClass($user->level) }}">
              {{ $user->levelLabel() }}
            </span>
          </div>
        </div>

        <form method="POST" action="{{ route('akses.update', $user->id) }}">
          @csrf
          @method('PUT')

          <div class="table-responsive">
            <table class="table" style="background:var(--bg-card); border-radius:10px;">
              <thead>
                <tr>
                  <th>Fitur Modul</th>
                  <th style="text-align:center; width:110px;">Lihat (Read)</th>
                  <th style="text-align:center; width:110px;">Tambah (Create)</th>
                  <th style="text-align:center; width:110px;">Edit (Update)</th>
                  <th style="text-align:center; width:110px;">Hapus (Delete)</th>
                </tr>
              </thead>
              <tbody>
                @foreach($features as $featKey => $featLabel)
                  @php
                    $perm = $user->permissions->firstWhere('feature', $featKey);
                  @endphp
                  <tr>
                    <td><strong>{{ $featLabel }}</strong></td>
                    <td style="text-align:center;">
                      <input type="checkbox" name="permissions[{{ $featKey }}][read]" value="1" {{ ($perm && $perm->can_read) || $user->isOwner() ? 'checked' : '' }}>
                    </td>
                    <td style="text-align:center;">
                      <input type="checkbox" name="permissions[{{ $featKey }}][create]" value="1" {{ ($perm && $perm->can_create) || $user->isOwner() ? 'checked' : '' }}>
                    </td>
                    <td style="text-align:center;">
                      <input type="checkbox" name="permissions[{{ $featKey }}][update]" value="1" {{ ($perm && $perm->can_update) || $user->isOwner() ? 'checked' : '' }}>
                    </td>
                    <td style="text-align:center;">
                      <input type="checkbox" name="permissions[{{ $featKey }}][delete]" value="1" {{ ($perm && $perm->can_delete) || $user->isOwner() ? 'checked' : '' }}>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <div style="margin-top:14px; text-align:right;">
            <button type="submit" class="btn btn-primary">Simpan Hak Akses {{ $user->username }} ➔</button>
          </div>
        </form>
      </div>
    @endforeach
  @endif
</div>
@endsection
