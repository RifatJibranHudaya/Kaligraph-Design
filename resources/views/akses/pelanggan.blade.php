@extends('layouts.app')

@section('title', 'Hak Akses Level Pelanggan')

@section('content')
<!-- Sub-Navigation Header -->
<div style="display:flex; gap:10px; margin-bottom:20px; flex-wrap:wrap;">
  <a href="{{ route('users.index') }}" class="btn btn-secondary" style="font-weight:700;">
    Admin & Staf
  </a>
  <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary" style="font-weight:700;">
    Data Pelanggan
  </a>
  <a href="{{ route('akses.index') }}" class="btn btn-secondary" style="font-weight:700;">
    Hak Akses Admin & Staf
  </a>
  <a href="{{ route('akses.pelanggan') }}" class="btn btn-primary" style="font-weight:700;">
    Hak Akses Level Pelanggan
  </a>
</div>

<div class="card">
  <div class="card-header" style="flex-wrap:wrap; gap:12px;">
    <div>
      <h3 class="card-title">Pengaturan Hak Akses Level Pelanggan (Semua Pelanggan)</h3>
      <div style="font-size:12px; color:var(--text-muted); margin-top:2px;">
        Konfigurasi izin fitur portal yang berlaku untuk <strong>seluruh akun pelanggan terdaftar ({{ $customerCount }} pelanggan)</strong> serta pendaftar baru.
      </div>
    </div>
    <!-- Quick Preset Buttons -->
    <div style="display:flex; gap:8px; flex-wrap:wrap;">
      <button type="button" class="btn btn-sm btn-secondary" onclick="applyPreset('all')">
        ✅ Izinkan Semua
      </button>
      <button type="button" class="btn btn-sm btn-secondary" onclick="applyPreset('standard')">
        ⚡ Standar Portal
      </button>
      <button type="button" class="btn btn-sm btn-secondary" onclick="applyPreset('readonly')">
        👁️ Hanya Lihat
      </button>
    </div>
  </div>

  <div style="padding:16px 20px; background:linear-gradient(135deg, rgba(37,99,235,0.06), rgba(16,185,129,0.06)); border-radius:12px; margin-bottom:24px; border:1px solid rgba(37,99,235,0.15); display:flex; align-items:center; gap:12px;">
    <span style="font-size:24px;"></span>
    <div style="font-size:13px; color:var(--text-main); line-height:1.5;">
      <strong>Pengaturan Terpusat:</strong> Anda tidak perlu mencentang izin satu per satu untuk setiap pelanggan. Mengubah pengaturan di bawah ini akan langsung mengontrol akses fitur untuk seluruh akun pelanggan di portal.
    </div>
  </div>

  <form method="POST" action="{{ route('akses.pelanggan.update') }}" id="customerPermForm">
    @csrf
    @method('PUT')

    <div class="table-responsive">
      <table class="table" style="background:var(--bg-card); border-radius:12px;">
        <thead>
          <tr>
            <th style="min-width:280px;">Fitur & Layanan Portal Pelanggan</th>
            <th style="text-align:center; width:130px;">Akses / Lihat<br><small style="font-weight:normal; font-size:11px;">(Read)</small></th>
            <th style="text-align:center; width:130px;">Buat / Ajukan<br><small style="font-weight:normal; font-size:11px;">(Create)</small></th>
            <th style="text-align:center; width:130px;">Ubah / Edit<br><small style="font-weight:normal; font-size:11px;">(Update)</small></th>
            <th style="text-align:center; width:130px;">Batalkan / Hapus<br><small style="font-weight:normal; font-size:11px;">(Delete)</small></th>
          </tr>
        </thead>
        <tbody>
          @foreach($customerFeatures as $featKey => $feat)
            @php
              $perm = $rolePermissions->get($featKey);
              $canRead = $perm ? $perm->can_read : true;
              $canCreate = $perm ? $perm->can_create : true;
              $canUpdate = $perm ? $perm->can_update : false;
              $canDelete = $perm ? $perm->can_delete : false;
            @endphp
            <tr>
              <td>
                <div style="font-weight:700; font-size:14px; color:var(--text-main);">
                  {{ $feat['label'] }}
                </div>
                <div style="font-size:12px; color:var(--text-muted); margin-top:2px;">
                  {{ $feat['desc'] }}
                </div>
              </td>
              <td style="text-align:center;">
                <input type="checkbox" name="permissions[{{ $featKey }}][read]" class="perm-read" value="1" {{ $canRead ? 'checked' : '' }}>
              </td>
              <td style="text-align:center;">
                <input type="checkbox" name="permissions[{{ $featKey }}][create]" class="perm-create" value="1" {{ $canCreate ? 'checked' : '' }}>
              </td>
              <td style="text-align:center;">
                <input type="checkbox" name="permissions[{{ $featKey }}][update]" class="perm-update" value="1" {{ $canUpdate ? 'checked' : '' }}>
              </td>
              <td style="text-align:center;">
                <input type="checkbox" name="permissions[{{ $featKey }}][delete]" class="perm-delete" value="1" {{ $canDelete ? 'checked' : '' }}>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div style="margin-top:24px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
      <div style="font-size:12px; color:var(--text-muted);">
        Perubahan akan langsung berlaku pada sesi login seluruh pelanggan.
      </div>
      <button type="submit" class="btn btn-primary" style="padding:12px 28px; font-weight:700;">
        💾 Simpan Hak Akses Level Pelanggan ➔
      </button>
    </div>
  </form>
</div>
@endsection

@section('scripts')
<script>
function applyPreset(type) {
  const reads = document.querySelectorAll('.perm-read');
  const creates = document.querySelectorAll('.perm-create');
  const updates = document.querySelectorAll('.perm-update');
  const deletes = document.querySelectorAll('.perm-delete');

  if (type === 'all') {
    reads.forEach(cb => cb.checked = true);
    creates.forEach(cb => cb.checked = true);
    updates.forEach(cb => cb.checked = true);
    deletes.forEach(cb => cb.checked = true);
  } else if (type === 'standard') {
    reads.forEach(cb => cb.checked = true);
    creates.forEach(cb => cb.checked = true);
    updates.forEach(cb => cb.checked = false);
    deletes.forEach(cb => cb.checked = false);
    // Specifically allow update for payment confirmation
    const paymentUpdate = document.querySelector('input[name="permissions[cust_payment_confirm][update]"]');
    if (paymentUpdate) paymentUpdate.checked = true;
  } else if (type === 'readonly') {
    reads.forEach(cb => cb.checked = true);
    creates.forEach(cb => cb.checked = false);
    updates.forEach(cb => cb.checked = false);
    deletes.forEach(cb => cb.checked = false);
  }
}
</script>
@endsection
