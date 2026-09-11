@extends('layouts.app')

@section('title', 'Data Pelanggan')

@section('content')
<!-- Sub-Navigation Header -->
<div style="display:flex; gap:10px; margin-bottom:20px; flex-wrap:wrap;">
  <a href="{{ route('users.index') }}" class="btn btn-secondary" style="font-weight:700;">
    Admin & Staf
  </a>
  <a href="{{ route('pelanggan.index') }}" class="btn btn-primary" style="font-weight:700;">
    Data Pelanggan ({{ $customers->count() }})
  </a>
  <a href="{{ route('akses.index') }}" class="btn btn-secondary" style="font-weight:700;">
    Hak Akses Admin & Staf
  </a>
  <a href="{{ route('akses.pelanggan') }}" class="btn btn-secondary" style="font-weight:700;">
    Hak Akses Level Pelanggan
  </a>
</div>

<div class="grid grid-2">
  <!-- Form Tambah Pelanggan Baru -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Tambah Akun Pelanggan Baru</h3>
    </div>
    <form method="POST" action="{{ route('pelanggan.store') }}">
      @csrf
      <div class="form-group">
        <label class="form-label">Username Pelanggan *</label>
        <input type="text" name="username" class="form-control" placeholder="cth. bpk_ahmad" value="{{ old('username') }}" required>
      </div>

      <div class="form-group">
        <label class="form-label">Email Pelanggan *</label>
        <input type="email" name="email" class="form-control" placeholder="ahmad@gmail.com" value="{{ old('email') }}" required>
      </div>

      <div class="form-group">
        <label class="form-label">No. WhatsApp / HP *</label>
        <input type="text" name="phone" class="form-control" placeholder="08123456789" value="{{ old('phone') }}" required>
      </div>

      <div class="form-group">
        <label class="form-label">Password Awal *</label>
        <input type="password" name="password" class="form-control" minlength="6" placeholder="Minimal 6 karakter" required>
      </div>

      <button type="submit" class="btn btn-primary" style="width:100%;">Daftarkan Pelanggan ➔</button>
    </form>
  </div>

  <!-- Daftar Pelanggan -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Daftar Pelanggan Terdaftar ({{ $customers->count() }})</h3>
    </div>
    <div class="table-responsive">
      <table class="table" id="pelangganTable">
        <thead>
          <tr>
            <th>Pelanggan</th>
            <th>Kontak WhatsApp</th>
            <th>Total Order</th>
            <th>Tgl Daftar</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($customers as $c)
            @php
              $cleanPhone = preg_replace('/[^0-9]/', '', $c->phone ?? '');
              if (str_starts_with($cleanPhone, '0')) {
                $cleanPhone = '62' . substr($cleanPhone, 1);
              }
            @endphp
            <tr>
              <td>
                <div style="display:flex; align-items:center; gap:10px;">
                  <div style="width:36px; height:36px; border-radius:50%; background:linear-gradient(135deg, #10b981, #059669); color:#fff; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:14px; flex-shrink:0;">
                    {{ strtoupper(substr($c->username, 0, 1)) }}
                  </div>
                  <div>
                    <strong>{{ $c->username }}</strong>
                    <div style="font-size:11px; color:var(--text-muted);">{{ $c->email }}</div>
                  </div>
                </div>
              </td>
              <td>
                @if($c->phone)
                  <a href="https://wa.me/{{ $cleanPhone }}?text=Halo%20{{ urlencode($c->username) }}%2C%20terima%20kasih%20telah%20menghubungi%20Kaligraph%20Design." target="_blank" class="badge badge-success" style="text-decoration:none; display:inline-flex; align-items:center; gap:4px; font-size:12px; padding:4px 8px;">
                    {{ $c->phone }}
                  </a>
                @else
                  <span style="font-size:12px; color:var(--text-muted);">-</span>
                @endif
              </td>
              <td>
                <span class="badge badge-primary" style="font-size:11px;">
                  {{ $c->orders_count ?? 0 }} Pesanan
                </span>
                @if(($c->orders_sum_total ?? 0) > 0)
                  <div style="font-size:11px; font-weight:700; color:var(--primary); margin-top:2px;">
                    {{ \App\Helpers\FormatHelper::rupiah($c->orders_sum_total) }}
                  </div>
                @endif
              </td>
              <td style="font-size:12px;">{{ $c->created_at ? $c->created_at->format('d/m/Y') : '-' }}</td>
              <td>
                <div style="display:flex; gap:6px;">
                  <button type="button" class="btn btn-sm btn-secondary" title="Edit Pelanggan" onclick="openEditPelangganModal({{ $c->id }}, '{{ addslashes($c->username) }}', '{{ addslashes($c->email) }}', '{{ addslashes($c->phone ?? '') }}')">
                    ✏️
                  </button>
                  <form method="POST" action="{{ route('pelanggan.destroy', $c->id) }}" onsubmit="return confirm('Hapus akun pelanggan {{ $c->username }}? Seluruh riwayat order akan terpengaruh.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus Pelanggan">🗑️</button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" style="text-align:center; color:var(--text-muted); padding:30px;">
                Belum ada data pelanggan yang terdaftar.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Edit Pelanggan -->
<div id="editPelangganModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); z-index:9999; align-items:center; justify-content:center; padding:20px;">
  <div class="card" style="width:100%; max-width:480px; background:var(--bg-card); margin:0; border-radius:20px; box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);">
    <div class="card-header">
      <h3 class="card-title">Edit Data Pelanggan</h3>
      <button type="button" onclick="closeEditPelangganModal()" style="background:none; border:none; font-size:20px; cursor:pointer; color:var(--text-main);">✕</button>
    </div>
    <form id="editPelangganForm" method="POST" action="">
      @csrf
      @method('PUT')
      <div class="form-group">
        <label class="form-label">Username Pelanggan *</label>
        <input type="text" name="username" id="edit_cust_username" class="form-control" required>
      </div>

      <div class="form-group">
        <label class="form-label">Email Pelanggan *</label>
        <input type="email" name="email" id="edit_cust_email" class="form-control" required>
      </div>

      <div class="form-group">
        <label class="form-label">Nomor WhatsApp / HP *</label>
        <input type="text" name="phone" id="edit_cust_phone" class="form-control" required>
      </div>

      <div class="form-group">
        <label class="form-label">Ganti Password (Kosongkan jika tidak diubah)</label>
        <input type="password" name="password" class="form-control" minlength="6" placeholder="Password baru...">
      </div>

      <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:20px;">
        <button type="button" class="btn btn-secondary" onclick="closeEditPelangganModal()">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Perubahan ➔</button>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
  $('#pelangganTable').DataTable({
    order: [[3, 'desc']],
    pageLength: 10,
    columnDefs: [
      { orderable: false, targets: [4] }
    ]
  });
});

function openEditPelangganModal(id, username, email, phone) {
  document.getElementById('editPelangganForm').action = "{{ url('pelanggan') }}/" + id;
  document.getElementById('edit_cust_username').value = username;
  document.getElementById('edit_cust_email').value = email;
  document.getElementById('edit_cust_phone').value = phone;
  document.getElementById('editPelangganModal').style.display = 'flex';
}

function closeEditPelangganModal() {
  document.getElementById('editPelangganModal').style.display = 'none';
}
</script>
@endsection
