<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ActivityLogController extends Controller
{
    /** Batas baris sebelum auto-archive dipicu */
    const ARCHIVE_THRESHOLD = 10000;

    public function index(Request $request)
    {
        $query = ActivityLog::with('user');

        if ($request->filled('module')) {
            $query->where('module', $request->module);
        }
        if ($request->filled('username')) {
            $query->where('username', 'like', "%{$request->username}%");
        }
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }

        $logs    = $query->latest('id')->get();
        $modules = ActivityLog::distinct()->pluck('module');

        // Statistik untuk UI warning
        $totalCount    = ActivityLog::count();
        $threshold     = self::ARCHIVE_THRESHOLD;
        $usagePercent  = $threshold > 0 ? min(100, round(($totalCount / $threshold) * 100)) : 0;
        $archiveFiles  = $this->getArchiveFiles();

        return view('activity_log.index', compact(
            'logs', 'modules', 'totalCount', 'threshold', 'usagePercent', 'archiveFiles'
        ));
    }

    /** Export log saat ini (ter-filter) ke CSV dan download langsung */
    public function exportCsv(Request $request)
    {
        if (!auth()->user()->isSuperadmin()) {
            return back()->with('error', 'Hanya Superadmin yang dapat mengekspor log aktivitas.');
        }

        $query = ActivityLog::query();

        if ($request->filled('module')) {
            $query->where('module', $request->module);
        }
        if ($request->filled('username')) {
            $query->where('username', 'like', "%{$request->username}%");
        }
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }

        $filename = 'activity_log_export_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($query) {
            $handle = fopen('php://output', 'w');
            // BOM untuk Excel agar karakter UTF-8 terbaca benar
            fputs($handle, "\xEF\xBB\xBF");
            // Header kolom
            fputcsv($handle, ['ID', 'Waktu (WIB)', 'Username', 'Modul', 'Aksi', 'Deskripsi', 'IP Address', 'Target ID']);

            // Chunk 500 baris agar tidak makan banyak memori
            $query->latest('id')->chunk(500, function ($rows) use ($handle) {
                foreach ($rows as $log) {
                    fputcsv($handle, [
                        $log->id,
                        $log->created_at ? $log->created_at->setTimezone('Asia/Jakarta')->format('d/m/Y H:i:s') : '-',
                        $log->username,
                        strtoupper($log->module),
                        $log->action,
                        $log->description,
                        $log->ip_address,
                        $log->target_id,
                    ]);
                }
            });

            fclose($handle);
        };

        ActivityLogService::log('export_csv', 'activity_log', "Export CSV log aktivitas diunduh oleh " . auth()->user()->username);

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Archive manual: ekspor SEMUA log ke CSV lalu hapus dari DB,
     * menyisakan 100 entri terbaru sebagai konteks.
     */
    public function archive(Request $request)
    {
        if (!auth()->user()->isSuperadmin()) {
            return back()->with('error', 'Hanya Superadmin yang dapat mengarsipkan log aktivitas.');
        }

        $count = ActivityLog::count();
        if ($count === 0) {
            return back()->with('error', 'Tidak ada log untuk diarsipkan.');
        }

        $archived = $this->runArchive();

        ActivityLogService::log('archive_logs', 'activity_log', "Log diarsipkan ke CSV: {$archived} baris disimpan, sisa DB dibersihkan.");

        return back()->with('success', "✅ Berhasil mengarsipkan {$archived} baris log ke file CSV. Database telah dibersihkan.");
    }

    /** Hapus semua log (truncate) */
    public function clear(Request $request)
    {
        if (!auth()->user()->isSuperadmin()) {
            return back()->with('error', 'Hanya Superadmin yang dapat membersihkan log aktivitas.');
        }

        ActivityLog::truncate();

        ActivityLogService::log('clear_logs', 'activity_log', 'Seluruh log aktivitas dibersihkan');

        return back()->with('success', 'Seluruh log aktivitas berhasil dibersihkan.');
    }

    /** Download file arsip CSV yang sudah tersimpan di storage */
    public function downloadArchive(string $filename)
    {
        if (!auth()->user()->isSuperadmin()) {
            abort(403);
        }

        // Sanitasi filename — hanya izinkan karakter aman
        $filename = basename($filename);
        $path     = 'activity_log_archives/' . $filename;

        if (!Storage::disk('local')->exists($path)) {
            return back()->with('error', 'File arsip tidak ditemukan.');
        }

        return Storage::disk('local')->download($path, $filename);
    }

    // ─── Helper ──────────────────────────────────────────────────────────────

    /**
     * Jalankan proses archive: simpan semua log ke CSV di storage/app/activity_log_archives/,
     * lalu hapus semua kecuali 100 baris terbaru dari DB.
     * Mengembalikan jumlah baris yang diarsipkan.
     */
    public static function runArchive(): int
    {
        $archiveDir = storage_path('app/activity_log_archives');
        if (!is_dir($archiveDir)) {
            mkdir($archiveDir, 0755, true);
        }

        $filename = 'activity_log_archive_' . now()->format('Ymd_His') . '.csv';
        $filepath = $archiveDir . '/' . $filename;

        $handle    = fopen($filepath, 'w');
        // BOM untuk Excel
        fputs($handle, "\xEF\xBB\xBF");
        fputcsv($handle, ['ID', 'Waktu (WIB)', 'Username', 'Modul', 'Aksi', 'Deskripsi', 'IP Address', 'Target ID']);

        $totalArchived = 0;

        // Ambil ID 100 terbaru yang akan dipertahankan di DB
        $keepIds = ActivityLog::latest('id')->limit(100)->pluck('id')->toArray();

        // Tulis ke CSV semua log yang TIDAK dalam keepIds (yang akan dihapus)
        ActivityLog::when(!empty($keepIds), fn($q) => $q->whereNotIn('id', $keepIds))
            ->oldest('id')
            ->chunk(500, function ($rows) use ($handle, &$totalArchived) {
                foreach ($rows as $log) {
                    fputcsv($handle, [
                        $log->id,
                        $log->created_at ? $log->created_at->setTimezone('Asia/Jakarta')->format('d/m/Y H:i:s') : '-',
                        $log->username,
                        strtoupper($log->module),
                        $log->action,
                        $log->description,
                        $log->ip_address,
                        $log->target_id,
                    ]);
                    $totalArchived++;
                }
            });

        fclose($handle);

        // Hapus baris yang sudah diarsipkan dari DB
        if (!empty($keepIds)) {
            ActivityLog::whereNotIn('id', $keepIds)->delete();
        } else {
            ActivityLog::truncate();
        }

        return $totalArchived;
    }

    /** Dapatkan daftar file arsip yang tersimpan */
    private function getArchiveFiles(): array
    {
        $archiveDir = storage_path('app/activity_log_archives');
        if (!is_dir($archiveDir)) {
            return [];
        }

        $files = glob($archiveDir . '/activity_log_archive_*.csv');
        $result = [];

        foreach (array_reverse($files) as $file) {
            $result[] = [
                'name'     => basename($file),
                'size'     => round(filesize($file) / 1024, 1), // KB
                'modified' => date('d/m/Y H:i', filemtime($file)),
            ];
        }

        return array_slice($result, 0, 20); // maksimal 20 file ditampilkan
    }
}
