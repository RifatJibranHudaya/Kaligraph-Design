@extends('layouts.app')

@section('title', 'Log Aktivitas Sistem')

@section('styles')
<style>
  /* ─── Usage Meter ─── */
  .log-stat-bar {
    height: 8px;
    border-radius: 4px;
    background: var(--surface-soft, #f1f4f7);
    overflow: hidden;
    margin-top: 6px;
  }
  .log-stat-bar-fill {
    height: 100%;
    border-radius: 4px;
    transition: width 0.6s ease;
  }
  .log-stat-bar-fill.level-ok      { background: #22c55e; }
  .log-stat-bar-fill.level-warn    { background: #f59e0b; }
  .log-stat-bar-fill.level-danger  { background: #ef4444; animation: pulse-danger 1.4s infinite; }

  @keyframes pulse-danger {
    0%, 100% { opacity: 1; }
    50%       { opacity: 0.65; }
  }

  .log-info-strip {
    display: flex;
    align-items: flex-start;
    gap: 20px;
    padding: 16px 20px;
    border-radius: 12px;
    margin-bottom: 18px;
    border: 1px solid var(--border-color, #dee3e9);
    background: var(--bg-card, #fff);
    flex-wrap: wrap;
  }

  .log-info-tile {
    display: flex;
    flex-direction: column;
    min-width: 140px;
  }
  .log-info-tile .lbl {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--text-muted, #5d6c7b);
    margin-bottom: 4px;
  }
  .log-info-tile .val {
    font-size: 22px;
    font-weight: 800;
    letter-spacing: -0.5px;
    color: var(--text-main, #0a1317);
  }
  .log-info-tile .sub {
    font-size: 11px;
    color: var(--text-muted, #5d6c7b);
    margin-top: 2px;
  }

  .log-info-meter {
    flex: 1;
    min-width: 200px;
    padding-left: 20px;
    border-left: 1px solid var(--border-color, #dee3e9);
  }

  .alert-autoarchive {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 14px 18px;
    border-radius: 10px;
    margin-bottom: 16px;
    font-size: 13.5px;
    font-weight: 600;
    line-height: 1.5;
  }
  .alert-autoarchive.info    { background: #eff6ff; border: 1px solid #bfdbfe; color: #1e40af; }
  .alert-autoarchive.warning { background: #fffbeb; border: 1px solid #fde68a; color: #92400e; }
  .alert-autoarchive.danger  { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }

  /* ─── Archive Files List ─── */
  .archive-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
    margin-top: 8px;
  }
  .archive-table th {
    background: var(--surface-soft, #f1f4f7);
    padding: 8px 12px;
    text-align: left;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--text-muted, #5d6c7b);
    border-bottom: 1px solid var(--border-color);
  }
  .archive-table td {
    padding: 10px 12px;
    border-bottom: 1px solid var(--border-color, #dee3e9);
    color: var(--text-main, #0a1317);
  }
  .archive-table tr:last-child td { border-bottom: none; }
  .archive-table tr:hover td { background: var(--surface-soft, #f1f4f7); }
</style>
@endsection

@section('content')
<div class="card">
  <div class="card-header" style="flex-wrap:wrap; gap:12px;">
    <div>
      <h3 class="card-title">Audit Trail Log Aktivitas Sistem</h3>
      <div style="font-size:12px; color:var(--text-muted); margin-top:2px;">
        Pencatatan riwayat transaksi, perubahan data produk, kategori, dan autentikasi.
        Auto-archive ke CSV dipicu otomatis saat log ≥ <strong>{{ number_format($threshold) }}</strong> baris.
      </div>
    </div>
    @if(auth()->user()->isSuperadmin())
      <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
        {{-- Export CSV (filtered) --}}
        <a href="{{ route('activity_log.export_csv', request()->query()) }}"
           class="btn btn-sm btn-success"
           title="Download log yang ditampilkan saat ini sebagai CSV">
          ⬇️ Export CSV
        </a>

        {{-- Archive manual --}}
        <form method="POST" action="{{ route('activity_log.archive') }}"
              onsubmit="return confirm('Arsipkan semua log lama ke CSV dan bersihkan database? 100 baris terbaru tetap dipertahankan.')">
          @csrf
          <button type="submit" class="btn btn-sm btn-warning" title="Simpan log ke CSV lalu bersihkan database">
            📦 Arsipkan ke CSV
          </button>
        </form>

        {{-- Clear all --}}
        <form method="POST" action="{{ route('activity_log.clear') }}"
              onsubmit="return confirm('HAPUS SEMUA log aktivitas tanpa backup CSV? Tindakan ini tidak bisa dibatalkan!')">
          @csrf
          <button type="submit" class="btn btn-sm btn-danger" title="Hapus seluruh log tanpa backup">
            🗑️ Bersihkan Log
          </button>
        </form>
      </div>
    @endif
  </div>

  {{-- ─── Flash Messages ─── --}}
  @if(session('success'))
    <div class="alert alert-success" style="margin: 16px 20px 0; padding: 12px 16px; border-radius: 10px; background:#d1fae5; border:1px solid #6ee7b7; color:#065f46; font-size:14px; font-weight:600;">
      ✅ {{ session('success') }}
    </div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger" style="margin: 16px 20px 0; padding: 12px 16px; border-radius: 10px; background:#fef2f2; border:1px solid #fecaca; color:#991b1b; font-size:14px; font-weight:600;">
      ❌ {{ session('error') }}
    </div>
  @endif

  <div style="padding: 20px 24px;">

    {{-- ─── Info Strip (Statistik penggunaan) ─── --}}
    <div class="log-info-strip">
      <div class="log-info-tile">
        <div class="lbl">Total Log di DB</div>
        <div class="val {{ $usagePercent >= 90 ? 'text-danger' : ($usagePercent >= 70 ? 'text-warning' : '') }}"
             style="{{ $usagePercent >= 90 ? 'color:#ef4444;' : ($usagePercent >= 70 ? 'color:#f59e0b;' : '') }}">
          {{ number_format($totalCount) }}
        </div>
        <div class="sub">baris dalam database</div>
      </div>

      <div class="log-info-tile">
        <div class="lbl">Batas Auto-Archive</div>
        <div class="val">{{ number_format($threshold) }}</div>
        <div class="sub">baris (konfigurasi sistem)</div>
      </div>

      <div class="log-info-tile">
        <div class="lbl">File Arsip CSV</div>
        <div class="val">{{ count($archiveFiles) }}</div>
        <div class="sub">tersimpan di server</div>
      </div>

      <div class="log-info-meter">
        <div style="display:flex; justify-content:space-between; font-size:12px; font-weight:700; margin-bottom:4px;">
          <span style="color:var(--text-muted);">Kapasitas Database Log</span>
          <span style="{{ $usagePercent >= 90 ? 'color:#ef4444;' : ($usagePercent >= 70 ? 'color:#f59e0b;' : 'color:#22c55e;') }}">
            {{ $usagePercent }}%
          </span>
        </div>
        <div class="log-stat-bar">
          <div class="log-stat-bar-fill {{ $usagePercent >= 90 ? 'level-danger' : ($usagePercent >= 70 ? 'level-warn' : 'level-ok') }}"
               style="width: {{ $usagePercent }}%;"></div>
        </div>
        <div style="font-size:11px; color:var(--text-muted); margin-top:6px;">
          Sisa {{ number_format($threshold - $totalCount) }} baris sebelum auto-archive dipicu
        </div>
      </div>
    </div>

    {{-- ─── Alert Banner ─── --}}
    @if($usagePercent >= 90)
      <div class="alert-autoarchive danger">
        <span style="font-size:20px;">🔴</span>
        <div>
          <strong>Peringatan Kritis!</strong> Log database mencapai <strong>{{ $usagePercent }}%</strong> kapasitas.
          Auto-archive akan segera dipicu secara otomatis, atau Anda dapat menekan <strong>"Arsipkan ke CSV"</strong> sekarang untuk mengamankan data.
        </div>
      </div>
    @elseif($usagePercent >= 70)
      <div class="alert-autoarchive warning">
        <span style="font-size:20px;">🟡</span>
        <div>
          <strong>Peringatan:</strong> Log database sudah mencapai <strong>{{ $usagePercent }}%</strong> dari batas.
          Disarankan untuk segera mengarsipkan log agar performa sistem tetap optimal.
        </div>
      </div>
    @else
      <div class="alert-autoarchive info">
        <span style="font-size:18px;">ℹ️</span>
        <div>
          Log akan <strong>otomatis diarsipkan ke CSV</strong> dan dibersihkan dari database ketika mencapai
          <strong>{{ number_format($threshold) }} baris</strong>. File CSV tersimpan di server dan dapat diunduh kapan saja.
        </div>
      </div>
    @endif

    {{-- ─── Filter Form ─── --}}
    <form method="GET" action="{{ route('activity_log.index') }}" style="display:flex; gap:10px; flex-wrap:wrap; margin-bottom:20px;">
      <select name="module" class="form-control" style="min-width:160px; max-width:200px; font-size:13px; padding:7px 10px;">
        <option value="">Semua Modul</option>
        @foreach($modules as $mod)
          <option value="{{ $mod }}" {{ request('module') == $mod ? 'selected' : '' }}>
            {{ strtoupper($mod) }}
          </option>
        @endforeach
      </select>
      <input type="text" name="username" class="form-control" placeholder="Filter username…"
             value="{{ request('username') }}" style="min-width:160px; max-width:200px; font-size:13px; padding:7px 10px;">
      <input type="date" name="tanggal_mulai" class="form-control"
             value="{{ request('tanggal_mulai') }}" style="font-size:13px; padding:7px 10px;" title="Dari Tanggal">
      <input type="date" name="tanggal_selesai" class="form-control"
             value="{{ request('tanggal_selesai') }}" style="font-size:13px; padding:7px 10px;" title="Sampai Tanggal">
      <button type="submit" class="btn btn-sm btn-primary">🔍 Filter</button>
      <a href="{{ route('activity_log.index') }}" class="btn btn-sm btn-secondary">✖ Reset</a>
    </form>

    {{-- ─── Log Table ─── --}}
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
            <tr {{ $log->action === 'auto_archive' || $log->action === 'archive_logs' ? 'style=background:rgba(245,158,11,0.06);' : '' }}>
              <td data-order="{{ $log->created_at ? $log->created_at->timestamp : 0 }}">
                <span style="font-size:12px; font-weight:600; white-space:nowrap;">
                  {{ $log->created_at ? $log->created_at->format('d/m/Y H:i:s') : '-' }}
                </span>
              </td>
              <td><strong>{{ $log->username }}</strong></td>
              <td><span class="badge badge-purple">{{ strtoupper($log->module) }}</span></td>
              <td>
                @if(in_array($log->action, ['auto_archive', 'archive_logs', 'export_csv', 'clear_logs']))
                  <span class="badge badge-warning" style="background:#fef3c7; color:#92400e;">{{ $log->action }}</span>
                @else
                  <span class="badge badge-primary">{{ $log->action }}</span>
                @endif
              </td>
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

    {{-- ─── Daftar File Arsip CSV ─── --}}
    @if(count($archiveFiles) > 0)
      <div style="margin-top: 32px;">
        <h4 style="font-size:15px; font-weight:800; margin-bottom:12px; color:var(--text-main);">
          📁 File Arsip CSV Tersimpan
        </h4>
        <div style="border:1px solid var(--border-color); border-radius:12px; overflow:hidden;">
          <table class="archive-table">
            <thead>
              <tr>
                <th>#</th>
                <th>Nama File</th>
                <th>Ukuran</th>
                <th>Terakhir Diubah</th>
                @if(auth()->user()->isSuperadmin())
                  <th>Aksi</th>
                @endif
              </tr>
            </thead>
            <tbody>
              @foreach($archiveFiles as $i => $file)
                <tr>
                  <td style="color:var(--text-muted); font-size:12px;">{{ $i + 1 }}</td>
                  <td>
                    <i style="opacity:0.5;">📄</i>
                    <code style="font-size:12px;">{{ $file['name'] }}</code>
                  </td>
                  <td style="white-space:nowrap;">{{ $file['size'] }} KB</td>
                  <td style="font-size:12px; white-space:nowrap;">{{ $file['modified'] }}</td>
                  @if(auth()->user()->isSuperadmin())
                    <td>
                      <a href="{{ route('activity_log.download_archive', $file['name']) }}"
                         class="btn btn-sm btn-success" style="font-size:12px; padding:4px 10px;">
                        ⬇️ Unduh
                      </a>
                    </td>
                  @endif
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div style="font-size:11px; color:var(--text-muted); margin-top:8px; padding-left:4px;">
          File arsip tersimpan di <code>storage/app/activity_log_archives/</code> pada server.
        </div>
      </div>
    @endif

  </div>{{-- end padding wrapper --}}
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
  $('#activityLogTable').DataTable({
    order: [[0, 'desc']],
    pageLength: 25,
    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
    language: {
      search: "Cari:",
      lengthMenu: "Tampilkan _MENU_ baris",
      info: "Menampilkan _START_–_END_ dari _TOTAL_ log",
      infoEmpty: "Tidak ada data",
      paginate: { previous: "‹", next: "›" },
      zeroRecords: "Tidak ada log yang cocok dengan filter."
    }
  });
});
</script>
@endsection
