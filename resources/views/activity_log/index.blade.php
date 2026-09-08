@extends('layouts.app')

@section('title', 'Log Aktivitas Sistem')

@section('content')
<div class="card">
  <div class="card-header" style="flex-wrap:wrap; gap:12px;">
    <div>
      <h3 class="card-title">📜 Audit Trail Log Aktivitas Sistem</h3>
      <div style="font-size:12px; color:var(--text-muted); margin-top:2px;">
        Pencatatan riwayat transaksi, perubahan data produk, kategori, dan autentikasi.
      </div>
    </div>
    <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
      @if(auth()->user()->isSuperadmin())
        <form method="POST" action="{{ route('activity_log.clear') }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus SELURUH log aktivitas sistem?')">
          @csrf
          <button type="submit" class="btn btn-sm btn-danger">🗑️ Bersihkan Log</button>
        </form>
      @endif
    </div>
  </div>

  <div class="table-responsive">
    <table class="table" id="activityLogTable">
      <thead>
        <tr>
          <th>Waktu (WIB)</th>
          <th>User</th>
          <th>Modul</th>
          <th>Aksi</th>
          <th>Deskripsi Audit</th>
          <th>IP Address</th>
        </tr>
      </thead>
      <tbody>
        @forelse($logs as $log)
          <tr>
            <td data-order="{{ $log->created_at ? $log->created_at->timestamp : 0 }}">
              <span style="font-size:12px; font-weight:600; white-space:nowrap;">
                {{ $log->created_at ? $log->created_at->format('d/m/Y H:i:s') : '-' }}
              </span>
            </td>
            <td><strong>{{ $log->username }}</strong></td>
            <td><span class="badge badge-purple">{{ strtoupper($log->module) }}</span></td>
            <td><span class="badge badge-primary">{{ $log->action }}</span></td>
            <td><span style="font-size:13px;">{{ $log->description }}</span></td>
            <td><code style="font-size:11px;">{{ $log->ip_address }}</code></td>
          </tr>
        @empty
          <tr>
            <td colspan="6" style="text-align:center; color:var(--text-muted); padding:30px;">
              Belum ada log aktivitas tercatat.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
  $('#activityLogTable').DataTable({
    order: [[0, 'desc']],
    pageLength: 25,
    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]]
  });
});
</script>
@endsection
