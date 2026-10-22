<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Log;

class ActivityLogService
{
    /** Batas baris di DB sebelum auto-archive CSV dipicu */
    const AUTO_ARCHIVE_THRESHOLD = 10000;

    /**
     * Log an action in the database.
     * Jika jumlah log mencapai batas AUTO_ARCHIVE_THRESHOLD,
     * log lama akan otomatis diarsipkan ke CSV dan dihapus dari DB.
     */
    public static function log(string $action, string $module, ?string $description = null, ?int $targetId = null): ActivityLog
    {
        $user = Auth::user() ?? Auth::guard('customer')->user();

        $entry = ActivityLog::create([
            'user_id'     => $user ? $user->id : null,
            'username'    => $user ? $user->username : 'Guest/System',
            'action'      => $action,
            'module'      => $module,
            'target_id'   => $targetId,
            'description' => $description,
            'ip_address'  => Request::ip() ?: '0.0.0.0',
            'created_at'  => now(),
        ]);

        // Cek threshold setiap 50 insert untuk mengurangi query COUNT berlebih
        // (hanya cek ketika ID log habis dibagi 50)
        if ($entry->id % 50 === 0) {
            static::checkAndAutoArchive();
        }

        return $entry;
    }

    /**
     * Periksa jumlah baris; jika >= threshold, jalankan auto-archive.
     * Auto-archive menyimpan semua log lama ke CSV dan membersihkan DB,
     * menyisakan 100 baris terbaru.
     */
    public static function checkAndAutoArchive(): void
    {
        try {
            $count = ActivityLog::count();

            if ($count >= self::AUTO_ARCHIVE_THRESHOLD) {
                // Hindari circular dependency dengan lazy-load controller
                $archived = \App\Http\Controllers\ActivityLogController::runArchive();

                // Catat event archive itu sendiri sebagai log baru
                ActivityLog::create([
                    'user_id'     => null,
                    'username'    => 'System/Auto-Archive',
                    'action'      => 'auto_archive',
                    'module'      => 'activity_log',
                    'target_id'   => null,
                    'description' => "Auto-archive dipicu: {$archived} baris diarsipkan ke CSV karena melebihi batas " . self::AUTO_ARCHIVE_THRESHOLD . " baris.",
                    'ip_address'  => '0.0.0.0',
                    'created_at'  => now(),
                ]);

                Log::info("[ActivityLog] Auto-archive selesai: {$archived} baris disimpan ke CSV.", [
                    'threshold' => self::AUTO_ARCHIVE_THRESHOLD,
                    'archived'  => $archived,
                    'timestamp' => now()->toDateTimeString(),
                ]);
            }
        } catch (\Throwable $e) {
            // Jangan sampai error archive membuat request gagal
            Log::error("[ActivityLog] Auto-archive gagal: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }
}
