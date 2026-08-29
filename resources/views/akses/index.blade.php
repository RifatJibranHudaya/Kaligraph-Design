@extends('layouts.app')

@section('title', 'Matriks Kelola Hak Akses Modul')

@section('content')
<div class="card">
  <div class="card-header">
    <h3 class="card-title">🔐 Pengaturan Hak Akses Pengguna (Permissions Matrix)</h3>
  </div>

  @if($users->isEmpty())
    <div style="text-align:center; color:var(--text-muted); padding:40px;">
      Tidak ada pengguna selain Superadmin untuk dikonfigurasi hak aksesnya.
    </div>
  @else
    @foreach($users as $user)
      <div style="border: 1px solid var(--border-color); border-radius: 12px; padding: 20px; margin-bottom: 24px; background: var(--bg-main);">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 16px;">
          <div>
            <h4 style="font-size:16px; font-weight:700;">👤 {{ $user->username }}</h4>
            <span class="badge {{ \App\Helpers\FormatHelper::levelBadgeClass($user->level) }}" style="margin-top:4px;">
              {{ strtoupper($user->level) }}
            </span>
          </div>
        </div>

        <form method="POST" action="{{ route('akses.update', $user->id) }}">
          @csrf
          @method('PUT')

          <div class="table-responsive">
            <table class="table" style="background:var(--bg-card); border-radius:8px;">
              <thead>
                <tr>
                  <th>Fitur Modul</th>
                  <th style="text-align:center;">Lihat (Read)</th>
                  <th style="text-align:center;">Tambah (Create)</th>
                  <th style="text-align:center;">Edit (Update)</th>
                  <th style="text-align:center;">Hapus (Delete)</th>
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
