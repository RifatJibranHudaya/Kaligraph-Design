<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
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

        $logs = $query->latest('id')->paginate(20);
        $modules = ActivityLog::distinct()->pluck('module');

        return view('activity_log.index', compact('logs', 'modules'));
    }

    public function clear(Request $request)
    {
        if (!auth()->user()->isSuperadmin()) {
            return back()->with('error', 'Hanya Superadmin yang dapat membersihkan log aktivitas.');
        }

        ActivityLog::truncate();

        ActivityLogService::log('clear_logs', 'activity_log', 'Seluruh log aktivitas dibersihkan');

        return back()->with('success', 'Seluruh log aktivitas berhasil dibersihkan.');
    }
}
